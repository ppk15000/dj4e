Installing DJango on PythonAnywhere
===================================

This is a more specific version of the documentation from PythonAnywhere (PYAW)
on how to install the Mozilla Developer Network (MDN) tutorial.

https://help.pythonanywhere.com/pages/FollowingTheDjangoTutorial/

https://developer.mozilla.org/en-US/docs/Learn/Server-side/Django/development_environment

Feel free to look at that page as well.

Once you have created your PYAW account, start a `bash` shell
and set up a virtual environment with Python 3.x and DJango 2.

    mkvirtualenv django2 --python=/usr/bin/python3.6
    pip install django ## this may take a couple of minutes

Note if you exit and re-start a new shell on PythonAnywhere - you need the following command
to get back into your virtual environment in the new bash shell.

    workon django2

In the PYAW shell, continue the steps from the MDN:

    cd ~
    mkdir django_projects
    cd django_projects
    django-admin startproject mytestsite

In the PYAW web interface navigate to the `Web` tab to create a new web application.  If you
have not already done so, add a new web application.  Select `manual configuration` and Python
3.6.  Once the webapp is created, you need to make a few changes to the settings for the web
app and your application.

source code: /home/--your-account---/django_projects/mytestsite
working directory: /home/--your-account---/django_projects/mytestsite
virtualenv: /home/--your-account---/.virtualenvs/django2

Then edit the *WGSI Configuration File* and put the following code into it.
This is slightly different from the sample in the PythonAnywhere tutorial.

    import os
    import sys

    path = os.path.expanduser('~/django_projects/mytestsite')
    if path not in sys.path:
        sys.path.insert(0, path)
    os.environ['DJANGO_SETTINGS_MODULE'] = 'mytestsite.settings'
    from django.core.wsgi import get_wsgi_application
    from django.contrib.staticfiles.handlers import StaticFilesHandler
    application = StaticFilesHandler(get_wsgi_application())

You need to edit the file `~/django_projects/mytestsite/mytestsite/settings.py` and change
the allowed hosts line (around line 28) to be:

     ALLOWED_HOSTS = [ '*' ]                                                                                                        

There are three ways to edit files in your PythonAnywhere environment, ranging from the easiest
to the coolest.

(1) Go to the main PythonAnywhere dashboard, browse files, navigate to the correct folder and edit the file

    /home/mdntutorial/django_projects/mytestsite/mytestsite/settings.py

(2) Or in the command line:

    cd ~/django_projects/mytestsite/mytestsite/
    nano settings.py

    Save the File by pressing 'CTRL-C', 'Y', and Enter

(3) Don't try this most difficult and most cool way to edit files on Linux without a helper
if it is your first time with the `vi` text editor.
    
    cd ~/django_projects/mytestsite/mytestsite/
    vi settings.py

Once you have opened `vi`, cursor down to the `ALLOWED_HOSTS` line,
position your cursor between the braces and press the
`i` key to go into 'INSERT' mode, then type your new text and press the `esc` key when you are
done.  To save the file, you type `:wq` followed by `enter`.  If you get lost press `escape` `:q!`
`enter` to get out of the file without saving.

If you aleady know some _other_ command line text editor in Linux, you can use it to edit files.  In general,
you will find that it often quicker and easier to make small edits to files in the command line
rather than a full screen UI.  And once you start deploying real applications in production
environments like Google, Amazon, Microsoft, etc.. all you will have is command line.

Once this file has been edited, on the PYAW Web page, restart your web application and check
that it is up and running:

    http://mdntutorial.pythonanywhere.com/
