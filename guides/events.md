# Events

Phase utilises standard Laravel events. Currently broadcasting is not supported and no events are broadcasted.

## Events as actions
One way in which events are built on in this project is by registering 'actions'. These actions are stored in the
'actions' table. An action is a database registration of an event, and they are useful for logging activity and events.
These events are in a tabled called 'actions' because the 'events' table is used to save user organised events.

*Example:*<br>
```
You wish to display an activity feed for a user which shows when they last changed their avatar. By creating a Laravel
event for this event which has a listener which saves the event to the database as an 'action', we can determine when
the user last changed their avatar when we come to generate the feed.
```

### Saving events as actions
You will notice in the ``App\Listeners`` directory there is a directory called ``ActionRegisters``. All these listeners
do is create a new 'action' in the database, and save the associated information with it. Each Laravel event which you
wish to save to the database as an action should have its own listener associated with it in that directory.

For every new event that you decide to save as an action, you must create an alias for the class name in the ``Action``
model.