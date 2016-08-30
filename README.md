GRIME DETECTOR
============================
Tool to recognition NEGATIVE comments based on artificial intelligence...

###What is it?
grimedetector is a text classification application with a focus on reuse, customizability 
and performance. Particularly useful in detecting negative (or positive) comments or just texts.
Application based on a Naive Bayes statistical classifier.

###Getting started

In order to set application up you must follow by steps:

1. Install VirtualBox, Vagrant,
2. Install the following vagrant plugins
    - Vagrant WinNFSd: `vagrant plugin install vagrant-winnfsd`
3. Go to vagrant directory: `cd vagrant`
4. Run Vagrant Virtual Machine `vagrant up`

### How to provision new server
```bash
ansible-playbook -i hosts provision.yml -u {USERNAME} -k -K
```

### Create archive with project 
```
composer archive --format=tar --file=grime-detector --dir=vagrant/provisioning/
```
### Deploy App
```
sudo ansible-galaxy install --force carlosbuenosvinos.ansistrano-deploy
ansible-playbook -i hosts deploy.yml -u {USERNAME} -k -K
```