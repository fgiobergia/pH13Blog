<h4><b>pH13Blog</b></h4>

pH13Blog aims to be a basic (hence the name) blogging platform. Blogging is not
perhaps the correct word, since pH13Blog is far less complicated than other 
platforms.

You can post new articles just by uploading a txt file in the right directory, 
and that's all: no need to use built-in editors. The platform consists in 5
PHP files: pretty much everybody can edit them and customize the platform.

The installation is rather easy as well: upload the files somewhere, edit your
config.php file (and eventually other files, if you need to), create a posts/
directory (you can change the directory name in config.php) and you're ready to
blog :-). 

Whenever you need to publish a new post, write it as a .txt file, upload it in
your posts/ directory (you can create subdirectories as well!) and rename the 
file using some random digits (followed by the extension). The post will then be
avaiable at the page blog/s.php?POSTID (with blog/ being the chosen path,
(e.g. http://darkjoker.voidsec.com/b/s.php?8509446 ).

A basic index has been added: this page will show a list of the latest posts
published,plus a list of categories available (i.e. a list of all the subdirs).
I strongly recommand not to publish posts in the "main" directory, since such
directory won't be shown in the categories list.

There's really nothing else to say: other infos are available as comments in the
files.

<b><i>darkjoker</i></b>
