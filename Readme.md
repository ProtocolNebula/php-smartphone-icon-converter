# PHP-Smartphone Icon Converter
This script convert an app Icon to all necessary sizes for the platform (including all necessary for Xamarin).
For now is only configured for ```iOs``` and ```Android```.

You can add any other configuration in ```config.php``` file.

## How to use LOCALLY:
1. Download / clone the project in your Apache/Nginx server (with php)
2. Set execute and write permissions to the folder (the script will create **out** and **temp**)
3. Configure (if you need) the **config.php** file.
4. Execute the script through Web Explorer (http://yourip/xamarinIconConverter)
5. Upload the file
6. Once end, you can get the files from ```out``` directory

## How to use Remotelly (without download):
https://icons.racs.es/

## After conversion:
In VisualStudio (or your IDE), go to ```yourApp.Droid``` / ```yourApp.iOs``` -> ```Resources``` and import the files (maybe you need to delete first the old).

If is the second time you do it and all files are already registered, you can directly replace the ```Resource``` folder in each platform.

## IMPORTANT:
The files only will be readed by "Xamarin" (Visual Studio) if you import them via IDE and NOT ONLY copying the files to Resource dir from Windows Explorer.
