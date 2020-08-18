import os
import subprocess as sp
plugin_name = input("Please enter plugin name")


all_demo=[['fb_clone',['otpsms', 'sesshortcut', 'sesarticle', 'seserrorpage','sesevent','seseventvideo','sesalbum', 'sespoke','sesadvsitenotification']],
          ['utube_clone',['activity','testapi']],
          ['instaclone_demo', ['sesbasic','sesalbum','sesvideo','sesfixedlayout','sesminify','sesdemouser','sesblog','eandstories','sesadvancedactivity','sesbasic']]
          ['courses_demo', ['Sesadvancedheader', 'Courses','Sesuserimport', 'Sesadvancedbanner','Sesfooter', 'Sesautoaction', 'Sescusdash','Seslandingpage','Sesfixedlayout','Seshtmlbackground','Sesminify','Sesloginpopup','Sesusercoverphoto','Sesdemouser','Sessociallogin','Sestestimonial','Sesmenu','Sesblog','Eandstories','Sesadvancedactivity','Sesbasic']]
          ['linkedinclone_demo', ['Sesuserimport', 'Sesevent', 'Sesalbum', 'Sesvideo', 'Sescommunityads', 'Sesfixedlayout', 'Sesgroup', 'Sesminify', 'Sesusercoverphoto', 'Sespymk', 'Sesgdpr', 'Sessocialshare', 'Sesqa', 'Quicksignup', 'Sesrecentlogin','Sesdemouser','Sessociallogin','Sesmetatag','Sesblog','Eandstories','Sesmember','Sesadvancedactivity','Sesbasic']]

          ]

#check out to plugins_tar file
os.system("git checkout plugins_tarfile")

# copy the tar file from plugins_tarfile to local
os.system("cp module-{}* /var/www/html".format(plugin_name))




for i in range(len(all_demo)):

    if plugin_name in all_demo[i][1]:

        #checkout to branch where we found plugin that we updated
        os.system("git checkout {}".format(all_demo[i][0]))

        #removed old package file
        os.system("git rm -rf application/packages/module-{}*".format(plugin_name))

        # extract tar file to branch
        os.system("tar -xvf /var/www/html/module-{}* -C /var/www/html/upgrade-plugins".format(plugin_name))

        # gave permission to package folder 
        os.system("chmod -R 777 application/packages")

        # delete tar file from the local
        os.system("rm -rf /var/www/html/module-{}*".format(plugin_name)) 

        os.system("git add .")
        os.system("git commit -m upgrade_plugin-{}".format(plugin_name))
        os.system("git push")

        os.system("sshpass -p 'Hse4kAH^pk@9+3=n' ssh -o StrictHostKeyChecking=no ec2-user@15.207.63.179 'cd /var/www/html/MyRepoTest && sudo git pull'")
        #untar module to current repo
        # git add for adding files changes
        # git commit -m "plugin_name upgrade successful"
        # git push 

