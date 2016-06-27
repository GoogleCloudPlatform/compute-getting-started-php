# Google Cloud Storage PHP Sample Application

## Description

This simple command-line application demonstrates how to invoke Google Cloud Storage from PHP.

## Build and Run
1.  **Enable APIs** - [Enable the Cloud Storage JSON API](https://console.cloud.google.com/flows/enableapi?apiid=storage_api)
    and create a new project or select an existing project.
2.  **Download The Credentials** - Click "Go to credentials" after enabling the APIs. Click "New Credentials"
    and select "Service Account Key". Create a new service account, use the JSON key type, and
    select "Create". Once downloaded, set the environment variable `GOOGLE_APPLICATION_CREDENTIALS`
    to the path of the JSON key that was downloaded.
3.  **Clone the repo** and cd into this directory

    ```sh
    $ git clone https://github.com/GoogleCloudPlatform/php-docs-samples
    $ cd php-docs-samples/storage/api
```
4.  **Install dependencies** via [Composer](http://getcomposer.org/doc/00-intro.md).
    Run `php composer.phar install` (if composer is installed locally) or `composer install`
    (if composer is installed globally).
5.  Run `php listBuckets.php YOUR_PROJECT_NAME` where YOUR_PROJECT_NAME is the
    project associated with the credentials from **step 2**.

    ```sh
    $ php listBuckets.php my-project-name
    my-project-name-bucket1
    my-project-name-bucket2
    my-project-name-bucket3
```
6.  Run `php listObjects.php YOUR_PROJECT_NAME YOUR_BUCKET_NAME` where YOUR_PROJECT_NAME is the
    project associated with the credentials from **step 2** and YOUR_BUCKET_NAME is a bucket from the list of bucket names in **step 5**.

    ```sh
    $ php listBuckets.php my-project-name my-project-name-bucket1
    my-project-name-bucket1-object1
    my-project-name-bucket1-object2
    my-project-name-bucket1-object3
```
7.  Run `php listObjects.php YOUR_PROJECT_NAME YOUR_BUCKET_NAME YOUR_OBJECT_NAME` where YOUR_PROJECT_NAME is the project associated with the credentials from **step 2** and YOUR_BUCKET_NAME is a bucket from the list of bucket names in **step 5** and YOUR_OBJECT_NAME is an object name from the list of objects in **step 6**.

    ```sh
    $ php downloadObject.php my-project-name my-project-name-bucket1 my-project-name-bucket1-object1 myfile.txt
    File written to myfile.txt
```


## Contributing changes

* See [CONTRIBUTING.md](../../CONTRIBUTING.md)

## Licensing

* See [LICENSE](../../LICENSE)
