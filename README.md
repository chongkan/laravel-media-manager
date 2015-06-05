# Media Manager
Laravel 4.2 Media Manager for Blade Templates

# Installation

1. Add the package to your composer.json file:    

    "require": {  
        "chongkan/media-manager" : 'dev-master'  
    }  

2. Install the package:    

    local-machine$ composer install  

3. Publish the package assets to your public folder, so they are available to the views:  
 
    $ php artisan asset:publish chongkan/media-manager  
    
4. Run the migrations:   
  
    $ php artisan migrate --package="chongkan/media-manager"  

5. Add the Service Provider, in the app/config/app.php, at the following line at the end of the 'providers' array:  

    'Chongkan\MediaManager\MediaManagerServiceProvider'  

6. Test your installation, navigate to:

    http://yourwebsite.dev/admin/medias   
    
    You should be redirected to the PingPong Admin Login page if not already logged in, if logged in, you should get the medias package interface.
    
    ![Test your Setup](http://chongkan.com/shares/permanent/2015-06-05_1139.png)

# Post Installation  

1. Add an admin menu.

    Extend the PingPong Package menu file.   

# Usage    
    
1. Drop files to the Drag and Drop area. 

    ![Drop Files](http://chongkan.com/shares/permanent/2015-06-05_1144.png)  
    
2. Click on a file to assign it to a position and assign CSS, Order and Publishing dates to it. 

    ![Editing Image assignments](http://chongkan.com/shares/permanent/2015-06-05_1145.png)  
    
3. In your Views, define the positions to insert the media file at: 

    [[mediaPosition myPicture]]  
    
    e.g.   
    
    ![Defining a position in your blades](http://chongkan.com/shares/permanent/2015-06-05_1148.png)
     

4. Tips:  

    a. You can assign more than one file to the same position and specify the orden in which they appear.   
    b. You can use CSS classes to manipulate, hide/show files in the same position.   