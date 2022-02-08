# Task Scheduling
Phase has some tasks which are executed on a schedule. For example, there is a job that is run every day that renews
subscriptions that are due for renewal at midnight on that day. This schedule is managed by Laravel but requires a single
cron job be setup on the server. See the [Laravel Task Scheduling Docs](https://laravel.com/docs/5.6/scheduling) on how
to set this up.