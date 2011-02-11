from fabric.api import local, run, env

env.hosts = ['mccutchen@overloaded.org']

def deploy():
    run('cd design.humortree.org && git pull --rebase')
