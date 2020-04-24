example config enqueue
```
enqueue:
    task:
        transport: 'amqp+lib://%enqueue.amqp.user%:%enqueue.amqp.pass%@%enqueue.amqp.host%:%enqueue.amqp.port%/%enqueue.amqp.vhost%'
        client:
            prefix: '%enqueue.client.prefix%.%app.name%'
            app_name: ''
            default_queue: '%enqueue.task.client.app%'
            router_topic:  '%enqueue.task.client.app%'
            router_queue:  '%enqueue.task.client.app%'
        job: true
    taskevent:
        transport: 'amqp+lib://%enqueue.amqp.user%:%enqueue.amqp.pass%@%enqueue.amqp.host%:%enqueue.amqp.port%/%enqueue.amqp.vhost%'
        client:
            prefix: '%enqueue.client.prefix%.%app.name%'
            app_name: ''
            default_queue: '%enqueue.taskevent.client.app%'
            router_topic:  '%enqueue.taskevent.client.app%'
            router_queue:  '%enqueue.taskevent.client.app%'
    event:
        transport: 'amqp+lib://%enqueue.amqp.user%:%enqueue.amqp.pass%@%enqueue.amqp.host%:%enqueue.amqp.port%/%enqueue.amqp.vhost%'
        client:
            prefix: '%enqueue.client.prefix%.%app.name%'
            app_name: ''
            default_queue: '%enqueue.event.client.app%'
            router_topic:  '%enqueue.event.client.app%'
            router_queue:  '%enqueue.event.client.app%'
```
parameters.yaml
```
    enqueue.amqp.host:  '%env(APP_RABBITMQ_HOST)%'
    enqueue.amqp.port:  '%env(APP_RABBITMQ_PORT)%'
    enqueue.amqp.user:  '%env(APP_RABBITMQ_USER)%'
    enqueue.amqp.pass:  '%env(APP_RABBITMQ_PASS)%'
    enqueue.amqp.vhost: '%env(APP_RABBITMQ_VHOST)%'

    app.name: 'test'
    enqueue.client.prefix: 'queue'

    enqueue.task.client.app: 'task'
    enqueue.taskevent.client.app: 'task.event'
    enqueue.event.client.app: 'event'

```
