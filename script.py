import os
import subprocess as sp
plugin_name = input("Please enter plugin name")


all_demo=[['fb_clone',['Otpsms', 'Sesshortcut', 'Sesarticle', 'Seserrorpage','Sesevent','Seseventvideo','Sesalbum', 'Sespoke','Sesadvsitenotification', '']], ['utube_clone',['activity','testapi']]]


for i in range(len(all_demo)):

	if plugin_name in all_demo[i][1]:

		sp.run("git checkout {}".format(all_demo[i][0]))
		sp.run("touch {}".format(all_demo[i][0]))
		 
		print("Plugin {} exist in {} demo".format(plugin_name, all_demo[i][0]))
		#sp.getoutput("cp that tar file to branch where to upgrade plugin repo")
		#git show <branch_name>:path/to/file >path/to/local/file
		#sp.getoutput("delete plugin package rm -rf path/to/plugin/module_name*")

		#untar module to current repo
		# git add for adding files changes
		# git commit -m "plugin_name upgrade successful"
		# git push 

	else:

		print("Plugin {} does not exist in {} demo".format(plugin_name, all_demo[i][0]))


