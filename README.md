This is an example of a use of the HTLE OAuth Functions

To set this up

Before Downloading, this repo requires
PHP version 7.1
Composer

1. Download this repo
2. Copy .env.example into a .env file with your access token
3. Run composer update
4. The following commands are now available:
* php main.php get-publishers (returns a list of available publishers with datasets)
* php main.php get-datasets {publisherSlug} (returns a list of available datasets for a publisher)
* php main.php get-data {publisherSlug} {datasetId} (returns data for a particular dataset)