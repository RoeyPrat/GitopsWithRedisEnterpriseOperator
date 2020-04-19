# GitOps with the Redis Enterprise Operator
A GitOps demonstration with the Redis Enterprise Operator.

The Guest book demo in this project is based on the excellent example in [kubernetes/examples](https://github.com/kubernetes/examples/tree/master/guestbook) repo. 
That demo has been modified to accept `REDIS_HOST`, `REDIS_PORT` and `REDIS_PASSWORD` as environment variables, to make it easier to connect an app to the Redis DB.
