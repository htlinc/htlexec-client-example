This is an example of authenticating with HTLExec and sending an API request

### Prerequisites
- PHP version 7.1+
- Composer (https://getcomposer.org/download/)

### Installation

1. Download the code and dependencies

```
git clone https://github.com/htlinc/htlexec-client-example
cd htlexec-client-example
composer update
```

2. Update your the .env file with your key

```
cp .env.example .env
vim .env
```

### Usage

```
# get an overview object that contains IDs of datasets and widgets
php main.php get-publisher

# get all data for the specified dataset
php main.php get-data {dataset_id}

# get all data for the specified widget
php main.php get-widget-data {dashboard_id} {widget_id}
```

Not all widgets can be exported. You will see an error "Widget Type Not Supported" if you attempt to export such a widget.


### Code

The example code is PHP, but should be easy to port to other languages:

1. Read API key from file
2. Set "Authorization: Bearer XXXXXXX" as a HTTP header
3. Send HTTP request to endpoint
4. Parse JSON response


### Data Format

All results are formatted as JSON.

Datasets are the core element. Each dataset contains multiple rows of data, generally row one per day. Typically there is a 1:1 correspondence between "a dataset" and "an ad network". Datasets need not be mutually exclusive, and two datasets may contain overlapping data if the user decides to set things up that way.

```
[...
	{
		"date": "2019-01-01",
		"impressions": 5000,
		"revenue": 15.20
	}
...]
```

Widgets are composed of one or more datasets and may include:
- derived/calculated columns
- aggregations

The data format is similar, ex:

```
[...
	{
		"date": "2019-01-01",
		"impressions": 2000,
		"revenue": 2.20,
		"CPM": 1.10
	}
...]
```


#### Versioning

The API is versioned via the URL, for example: `https://htlexec.com/api/oauth/1.0` refers to the `1.0` version of the API.

We may add additional metadata/fields in minor-version updates, ex: from `1.0` to `1.1`

We may add/remove endpoints and modify the data structures more significantly in major-version updates, ex: from `1.5` to `2.0`


