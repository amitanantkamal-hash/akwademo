<?php

namespace Modules\LeadManager\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\LeadManager\Models\Lead;

class LeadsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $companyId;
    protected $filters;
    
    public function __construct($companyId, $filters = [])
    {
        $this->companyId = $companyId;
        $this->filters = $filters;
    }
    
    public function collection()
    {
        $query = Lead::forCompany($this->companyId)
            ->with(['contact', 'agent']);
            
        if (!empty($this->filters)) {
            if (isset($this->filters['stage']) && $this->filters['stage']) {
                $query->where('stage', $this->filters['stage']);
            }
            
            if (isset($this->filters['agent_id']) && $this->filters['agent_id']) {
                $query->where('agent_id', $this->filters['agent_id']);
            }
            
            if (isset($this->filters['source']) && $this->filters['source']) {
                $query->where('source', 'like', '%' . $this->filters['source'] . '%');
            }
        }
        
        return $query->get();
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'Contact Name',
            'Phone',
            'Source',
            'Stage',
            'Agent',
            'Next Follow-up',
            'Created At'
        ];
    }
    
    public function map($lead): array
    {
        return [
            $lead->id,
            $lead->contact->name,
            $lead->contact->phone,
            $lead->source,
            $lead->stage,
            $lead->agent ? $lead->agent->name : 'Unassigned',
            $lead->next_followup_at ? $lead->next_followup_at->format('Y-m-d H:i') : '',
            $lead->created_at->format('Y-m-d H:i')
        ];
    }
}