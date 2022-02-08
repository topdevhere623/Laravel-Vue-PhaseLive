@component('mail::message')
# Phase Content

A new report has been submitted for a {{ $report->reportable->type }} on Phase. Log into the control panel to
review this report and the associated {{ $report->reportable->type }}.

## The user who reported the {{ $report->reportable->type }} was:
@component('mail::panel')
    {{ $report->user->name }}
@endcomponent

## The provided reason for the report was:
@component('mail::panel')
    {{ $report->message }}
@endcomponent

@component('mail::button', ['url' => $url])
    View Report
@endcomponent

@endcomponent
