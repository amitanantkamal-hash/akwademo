<?php


namespace Modules\Wpbox\Jobs;

use Modules\Wpbox\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ProcessCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;
    protected $requestData;

    public function __construct(Campaign $campaign, array $requestData = [])
    {
        $this->campaign = $campaign;
        $this->requestData = $requestData;
    }

    public function handle()
    {
        try {
            // Get contact IDs
            $contactIds = $this->campaign->getContactIds($this->requestData);
            
            // Demo mode: limit to 5 contacts
            if (config('settings.is_demo', false)) {
                $contactIds = array_slice($contactIds, 0, 5);
            }
            
            // Update send_to count
            $this->campaign->send_to = count($contactIds);
            $this->campaign->update();
            
            // Determine the job type based on request data
            $template = $this->campaign->template;
            $jobClass = ProcessCampaignMessages::class;
            
            if (isset($this->requestData['product_retailer_id']) && count($this->requestData['product_retailer_id']) > 0) {
                $jobClass = ProcessCampaignCarousel::class;
            } elseif (isset($this->requestData['slider_id']) && $this->requestData['slider_id'] == 'slider') {
                $jobClass = ProcessCampaignCarouselSlider::class;
            } elseif ($template && $template->type == '1') {
                $jobClass = ProcessCampaignCatalogMessages::class;
            }
            
            // Create batch jobs
            $chunkSize = 500; // Smaller chunks to prevent timeouts
            $chunks = array_chunk($contactIds, $chunkSize);
            $jobs = [];
            
            foreach ($chunks as $chunk) {
                $jobs[] = new $jobClass($this->campaign, $chunk, $this->requestData);
            }
            
            // Dispatch the batch
            Bus::batch($jobs)
                ->name('campaign-' . $this->campaign->id)
                ->dispatch();
                
        } catch (\Exception $e) {
            Log::error('Error processing campaign: ' . $e->getMessage());
            throw $e;
        }
    }
}