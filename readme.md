# Payment via Bitcoin with Laravel

A payment gateway server for Bitcoin made with Laravel.

## Dependencies

- PHP 5.6.4+
- NodeJS
- npm
- bower

## Install

Installing PHP dependencies:

```bash
composer update
```

Creating configuration file

```bash
cp .env.example .env
```

Creating Laravel key

```bash
php artisan key:generate
```

#### Configuration

Edit `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=payment_bitcoin
DB_USERNAME=root
DB_PASSWORD=password

BITCOIN_HOST=127.0.0.1
BITCOIN_PORT=18332
BITCOIN_USERNAME=username
BITCOIN_PASSWORD=password
BITCOIN_DEFAULT_ACCOUNT=account_name

MIN_PRICE=0.00009
SITE_FEE=5
```

Installing database:

```bash
php artisan migrate
```

#### Installing front-end dependencies:

Installing npm dependencies:

```
npm install
```

Installing bower dependencies:

```
bower install
```

Building front-end:

```
npm run production
```

## API

### Checkout

#### Request

```
POST /api/checkout?email=MAIL&token=TOKEN HTTP/1.1
Content-Type: application/json
```

```javascript
{
    "reference": "123",
    "notification_url": "http://mystore.com/payment/notification",
    "buyer": {
        "name": "Van Neves",
        "email": "client@email.com"
    },
    "items": [{
        "name": "Product Name",
        "amount": 1,
        "price": 0.000321
    }]
}
```

#### Response

```javascript
{
    "code": "F6788983BF366563BCF0D8E3DFBDF1B7",
    "status": 0,
    "created_at": "2018-03-02 01:57:49",
    "payment_url": "http://127.0.0.1:8080/checkout/F6788983BF366563BCF0D8E3DFBDF1B7"
}
```

### Notification

```
GET /api/notification/E1C4ECE6157720F15AC479631FE978C1?email=MAIL&token=TOKEN HTTP/1.1
Content-Type: application/json

```

#### Response

```javascript
{
    "code": "41D3436B1D6948E3A52197B65A9C350E",
    "reference": "123",
    "total": 0.00479338,
    "fee": 0.00023967,
    "status": 2,
    "created_at": "2017-09-01 19:42:56",
    "updated_at": "2017-09-04 02:33:27",
    "payments": [
        {
            "block": "00000000623aaa3d06f10bd7497a00177d3d14e66b71a758f173b26b2111fd35",
            "txid": "a71b06cc89af339b47bcff879a0e8ee085abaed8e26b12d187ba3860e8c1457d",
            "value": 2.6999,
            "received_at": "2017-05-27 02:30:52",
            "created_at": "2017-09-04 02:33:27",
            "updated_at": "2017-09-04 02:33:27"
        },
        {
            "block": "000000000000049b21043ca1e59a3ed4c5a47ec103b7fa0a7dfd5b78bf0756fd",
            "txid": "5a753535bd6649bb69d36484affcfa1c31bd310c3342c0078dc6e767e526b2f1",
            "value": 2.6898,
            "received_at": "2017-05-27 02:44:42",
            "created_at": "2017-09-04 02:33:27",
            "updated_at": "2017-09-04 02:33:27"
        }
    ]
}
```

### Transaction

```javascript
GET /api/transaction/E0D817967615B2940ECD78D6E37BD28F?email=MAIL&token=TOKEN HTTP/1.1
Content-Type: application/json

```

#### Response

```javascript
{
    "code": "785465DE8B995AE8627B39F2B36F65F9",
    "reference": "real2",
    "total": 0.00325733,
    "fee": 0.00016287,
    "status": 2,
    "created_at": "2017-09-01 19:42:56",
    "updated_at": "2017-09-04 02:33:27",
    "payments": [
        {
            "block": "00000000216755865d441ea8b8f08a5bd4e16c2902168c0f93aa7570af261e07",
            "txid": "5bdcb292ddedf790ace6b6d9362470415585a7d0f61528fe1f387632fdf4db99",
            "value": 0.275,
            "received_at": "2017-08-29 23:22:44",
            "created_at": "2017-09-04 02:33:27",
            "updated_at": "2017-09-04 02:33:27"
        },
        {
            "block": "000000002b3a755e96d962413e6276e12b645e52db5415adfcafa0e00d2d2afd",
            "txid": "39d80a5dd249c18dfa7c9ab36e25865237c440e82c9dca08cc4c4dbf0a265f3b",
            "value": 8.36405498,
            "received_at": "2017-09-02 03:05:56",
            "created_at": "2017-09-04 02:33:27",
            "updated_at": "2017-09-04 02:33:27"
        }
    ]
}
```

### Transactions

```javascript
GET /api/transactions?email=MAIL&token=TOKEN&start_date=2017-08-01T00:00&end_date=2018-08-31T23:00&page=1&max=10 HTTP/1.1
Content-Type: application/json
```

#### Response

```javascript
{
    "current_page": 1,
    "total_pages": 5,
    "transactions": [
        {
            "code": "E0D817967615B2940ECD78D6E37BD28F",
            "reference": "real4",
            "total": 0.00955041,
            "fee": 0.00047752,
            "status": 0,
            "created_at": "2017-09-01 19:42:56",
            "updated_at": "2017-09-01 19:42:56",
            "payments": []
        },
        {
            "code": "785465DE8B995AE8627B39F2B36F65F9",
            "reference": "real2",
            "total": 0.00325733,
            "fee": 0.00016287,
            "status": 2,
            "created_at": "2017-09-01 19:42:56",
            "updated_at": "2017-09-04 02:33:27",
            "payments": [
                {
                    "block": "00000000216755865d441ea8b8f08a5bd4e16c2902168c0f93aa7570af261e07",
                    "txid": "5bdcb292ddedf790ace6b6d9362470415585a7d0f61528fe1f387632fdf4db99",
                    "value": 0.275,
                    "received_at": "2017-08-29 23:22:44",
                    "created_at": "2017-09-04 02:33:27",
                    "updated_at": "2017-09-04 02:33:27"
                },
                {
                    "block": "000000002b3a755e96d962413e6276e12b645e52db5415adfcafa0e00d2d2afd",
                    "txid": "39d80a5dd249c18dfa7c9ab36e25865237c440e82c9dca08cc4c4dbf0a265f3b",
                    "value": 8.36405498,
                    "received_at": "2017-09-02 03:05:56",
                    "created_at": "2017-09-04 02:33:27",
                    "updated_at": "2017-09-04 02:33:27"
                }
            ]
        },
        {
            "code": "2876BF327CB52183D930A77C714EC149",
            "reference": "real3",
            "total": 0.00284749,
            "fee": 0.00014237,
            "status": 2,
            "created_at": "2017-09-01 19:42:56",
            "updated_at": "2017-09-04 02:33:27",
            "payments": [
                {
                    "block": "00000000000128bd48c1cdc11f619b4a3be4dca4bc428b776a30ed936dd79e65",
                    "txid": "473ae606ce9e61b089a38191d286abc0d6201427be2b953fa086f10f60ff593b",
                    "value": 1.1,
                    "received_at": "2017-08-29 22:13:42",
                    "created_at": "2017-09-04 02:33:27",
                    "updated_at": "2017-09-04 02:33:27"
                },
                {
                    "block": "00000000000128bd48c1cdc11f619b4a3be4dca4bc428b776a30ed936dd79e65",
                    "txid": "9c9b3c5fb2afe12234a67d6e8bd516669c329ea93d047bbe310a6b0b4e01e033",
                    "value": 0.55,
                    "received_at": "2017-08-29 22:18:27",
                    "created_at": "2017-09-04 02:33:27",
                    "updated_at": "2017-09-04 02:33:27"
                }
            ]
        },
        {
            "code": "41D3436B1D6948E3A52197B65A9C350E",
            "reference": "real4",
            "total": 0.00479338,
            "fee": 0.00023967,
            "status": 2,
            "created_at": "2017-09-01 19:42:56",
            "updated_at": "2017-09-04 02:33:27",
            "payments": [
                {
                    "block": "00000000623aaa3d06f10bd7497a00177d3d14e66b71a758f173b26b2111fd35",
                    "txid": "a71b06cc89af339b47bcff879a0e8ee085abaed8e26b12d187ba3860e8c1457d",
                    "value": 2.6999,
                    "received_at": "2017-05-27 02:30:52",
                    "created_at": "2017-09-04 02:33:27",
                    "updated_at": "2017-09-04 02:33:27"
                },
                {
                    "block": "000000000000049b21043ca1e59a3ed4c5a47ec103b7fa0a7dfd5b78bf0756fd",
                    "txid": "5a753535bd6649bb69d36484affcfa1c31bd310c3342c0078dc6e767e526b2f1",
                    "value": 2.6898,
                    "received_at": "2017-05-27 02:44:42",
                    "created_at": "2017-09-04 02:33:27",
                    "updated_at": "2017-09-04 02:33:27"
                }
            ]
        },
        {
            "code": "64870EA3B1EAD8C55ED9F3FE90194881",
            "reference": "123",
            "total": 0.000321,
            "fee": 0.00001605,
            "status": 0,
            "created_at": "2017-09-01 19:45:03",
            "updated_at": "2017-09-01 19:45:03",
            "payments": []
        },
        {
            "code": "8C1B1C5E4BF063BA01FEB758CC8C9A81",
            "reference": "123",
            "total": 0.000321,
            "fee": 0.00001605,
            "status": 0,
            "created_at": "2017-09-01 19:45:04",
            "updated_at": "2017-09-01 19:45:04",
            "payments": []
        },
        {
            "code": "7FCBD64087B6B3D1719EDD8D430E123B",
            "reference": "123",
            "total": 0.000321,
            "fee": 0.00001605,
            "status": 0,
            "created_at": "2017-09-01 19:45:05",
            "updated_at": "2017-09-01 19:45:05",
            "payments": []
        },
        {
            "code": "4DF5B5582B8EC1B5374B983119F213F2",
            "reference": "123",
            "total": 0.000321,
            "fee": 0.00001605,
            "status": 0,
            "created_at": "2017-09-01 19:45:06",
            "updated_at": "2017-09-01 19:45:06",
            "payments": []
        },
        {
            "code": "5202FBB31CD15CDB4A8D82D7438CA2E1",
            "reference": "123",
            "total": 0.000321,
            "fee": 0.00001605,
            "status": 0,
            "created_at": "2017-09-01 19:45:07",
            "updated_at": "2017-09-01 19:45:07",
            "payments": []
        },
        {
            "code": "BC1FC6B6F07A6B98129E3004BDA53596",
            "reference": "123",
            "total": 0.000321,
            "fee": 0.00001605,
            "status": 0,
            "created_at": "2017-09-01 19:45:08",
            "updated_at": "2017-09-01 19:45:08",
            "payments": []
        }
    ]
}
```

## License

The MIT License (MIT)