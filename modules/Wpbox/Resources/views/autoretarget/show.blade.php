@extends('client.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">AutoRetarget Campaign: {{ $autoretargetCampaign->name }}</h3>
                    <a href="{{ route('autoretarget.index') }}" class="btn btn-secondary">Back</a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Details</h5>
                            <p><strong>Name:</strong> {{ $autoretargetCampaign->name }}</p>
                            <p><strong>Description:</strong> {{ $autoretargetCampaign->description }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge badge-{{ $autoretargetCampaign->is_active ? 'success' : 'danger' }}">
                                    {{ $autoretargetCampaign->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('autoretarget.edit', $autoretargetCampaign) }}" class="btn btn-info">Edit</a>
                        </div>
                    </div>

                    <h5>Retargeting Messages</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Days After Delivery</th>
                                    <th>Send Time</th>
                                    <th>Campaign</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($autoretargetCampaign->messages as $message)
                                    <tr>
                                        <td>{{ $message->order }}</td>
                                        <td>{{ $message->delay_days }} days</td>
                                        <td>{{ $message->send_time }}</td>
                                        <td>{{ $message->campaign->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($autoretargetCampaign->logs->count() > 0)
                    <h5 class="mt-4">Execution Logs</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Contact</th>
                                    <th>Campaign</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($autoretargetCampaign->logs as $log)
                                    <tr>
                                        <td>{{ $log->sent_at->format('Y-m-d H:i') }}</td>
                                        <td>{{ $log->contact->name }} ({{ $log->contact->phone }})</td>
                                        <td>{{ $log->campaign->name }}</td>
                                        <td>
                                            <span class="badge badge-{{ $log->status == 'sent' ? 'success' : 'danger' }}">
                                                {{ $log->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection