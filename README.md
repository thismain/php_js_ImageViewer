php_js_ImageViewer is a no frills image viewer that makes thumbnails, links them to the fullsize image, and allows for panning and accurate zooming, centered on the cursor. 

1) Put the php files together in, say 'someFolder';

2) Make a folder in 'someFolder', say 'images';

3) Make a folder for thumbnails in 'images', which must be called 'thumbs';

4) Put your fullsize images alone in the folder called 'images;

5) Edit the 3 php files, thumbsU.php, imageViewerU.php, and deleterU.php, to make the path to 'someFolder' point to the actual name you chose for this folder;

6) Change the permissions on 'someFolder' and subfolders to read, write, execute:
On Ubuntu, in the console, the command was:
sudo chmod -R 777 /var/www/html/someFolder

7) Put some images in the 'images' folder;

8) On your local web server, load the url:
http://localhost/someFolder/thumbsU.php?folder=images

The Expected Result:
The thumbnails will be created and displayed. Each thumbnail is a link to the fullsize image, which may be viewed with panning and accurate zooming, centered on the cursor.