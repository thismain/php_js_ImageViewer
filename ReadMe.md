php_js_ImageViewer is a no frills image viewer that makes thumbnails, links them to the fullsize image, and allows for panning and accurate zooming, centered on the cursor. 

Put the php files together in, say 'someFolder';

Make a folder in 'someFolder', say 'images';

Make a folder for thumbnails in 'images', which must be called 'thumbs';

Put your fullsize images alone in the folder called 'images;

Edit the 3 php files, thumbsU.php, imageViewerU.php, and deleterU.php, to make the path to 'someFolder' point to the actual name you chose for this folder;

Change the permissions on 'someFolder' and subfolders to read, write, execute:

On Ubuntu, in the console, the command was:
sudo chmod -R 777 /var/www/html/someFolder

Put some images in the 'images' folder;

On your local web server, load the url:
http://localhost/someFolder/thumbsU.php?folder=images

The thumbnails will be created and displayed. Each thumbnail is a link to the fullsize image, which may be viewed with panning and accurate zooming, centered on the cursor.