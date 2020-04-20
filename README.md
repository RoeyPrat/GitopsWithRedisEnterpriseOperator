# GitOps with the Redis Enterprise Operator
A GitOps demonstration with the Redis Enterprise Operator.

The Guest book demo in this project is based on the excellent example in [kubernetes/examples](https://github.com/kubernetes/examples/tree/master/guestbook) repo. 
That demo has been modified to accept `REDIS_HOST`, `REDIS_PORT` and `REDIS_PASSWORD` as environment variables, to make it easier to connect an app to the Redis DB.

## set up flux CD for GitOps

We want changes to the git repo to be reflected in our k8s cluster.
Following the [fluxCD getting started guide](https://docs.fluxcd.io/en/latest/tutorials/get-started/):
1. install [fluxctl](https://docs.fluxcd.io/en/latest/references/fluxctl/)
2. Create the flux namespace: 
   `kubectl create ns flux` 
3. Install flux on your cluster, using fluxctl:
   ```shell script
   export GHUSER="YOURUSER"
   fluxctl install \
   --git-user=${GHUSER} \
   --git-email=${GHUSER}@users.noreply.github.com \
   --git-url=git@github.com:${GHUSER}/GitopsWithRedisEnterpriseOperator \
   --git-path=workloads \
   --namespace=flux | kubectl apply -f -
   ```
   You will need to use your github user and point to a fork of this repo. 
4. Wait for flux to start: `kubectl -n flux rollout status deployment/flux`
5. At startup Flux generates a SSH key and logs the public key. Find the SSH public key by running:
   ```shell script
   fluxctl identity --k8s-fwd-ns flux
   ```
6. In order to sync your cluster state with git you need to copy the public key and create a deploy key with write access on your GitHub repository.
   Open GitHub, navigate to your fork, go to Setting > Deploy keys, click on Add deploy key, give it a Title, check Allow write access, paste the Flux public key and click Add key. See the GitHub docs for more info on how to manage deploy keys.
7. Make changes, and see that your demo workloads are changing.
8. By default, Flux git pull frequency is set to 5 minutes. You can tell Flux to sync the changes immediately with:
   ```shell script
   fluxctl sync --k8s-fwd-ns flux
   ```