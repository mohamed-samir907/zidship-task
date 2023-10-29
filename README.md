# Zid Ship
This app has a unified module located in `app/Shipping` directory that handle the shipping functions in any platform without the need to custom implement courior integration independently.

I tried to make it as simple as I could, but also reliable, and extendable.

In order to achive that, I used known patterns and Princibles like `Open Closed Principle` which gaves me the flexabilty of adding any integration without break the constraints of the module. Also i have to use Strategy pattern and factory, all of them gaves me the flexability of switching between the platforms in the runtime.

You will see in the module the following directories:
- `DTOs` used DTO to transfer data between layers instead of using array which makes the data not clear, but using the DTO defines the structure and expected data types of the data it holds.
- `Enums`
- `Factories` contains the factories responsbile for creating the service that handle the action based on the platform.
- `Http`
- `Interfaces` Common interface any integration must implement.
- `Repositories`
- `Services` Contains the services that handle everything and switching between platforms.

You can look at the `AppServiceProvider` to see the interface & integrations bindings.

I created another directory `app/Integrations` which will contain any courier integration. The integration must implement the interfaces from the `app/Shipping` module.

**database**

I used MySQL for several reasons:
- It's easy to use in Laravel.
- The data entities in this task looks related to each other like (shipments, platforms, users, ...) so a relational database will be good for this case.
- It allows normailzing the data and quering between related tables easly.
- The performance can be improved easly when needed by adding propper index, and do query optimization.

**suggestions**
- instead of getting the status from the API direct which my take long time we can get it from the database direct.
- so to do that we should implement webhooks for the platforms support it to get the status of the shipment and update it with new status.
- in case of the platform not supporting webhooks, we can add a schedule commands and background jobs to get the status from the tracking service of each platform and update the status on our database.
- handle API rate limit.
- add mechanism to retry the failed requests in case of getting errors from the platform or rate limit error (like circuit breaker)
- we can enhance the shipment creation to be async using background jobs instead of the current behavior (sync). and when failuer we will notify the user. this will improve the UX.

**dummy courier**
I create `fake` Integration module `DummyCourier` which returns a hard coded values instead of the values from the real integration.

Why i created that module? I tried integration with `Aramex`, also the example provided `KwickBox` but I faced issues with login credentials and tokens. Moreover, I started the task late so I didn't have the time to investigate the issues. So i created the dummy module to use at as a Prove of Concept.

# Requirements
- PHP 8.2
- MySQL

# Installation
1. Clone the repository.
2. Copy `.env.example` as `.env` file.
```
cp .env.example .env
```
3. Create a database and edit `.env` file with your credentails.
4. Run the following command `php artisan migrate --seed` to create the tables and create test data.
5. Create a token for the user to be used in the API.
```
php artisan tinker
```
```php
$user = User::first();
$user->createToken("test")->plainTextToken;
```

# Tests
```
php artisan test
```

# API

## Path Table

| Method | Path | Description |
| --- | --- | --- |
| POST | [/api/v1/shipments](#postapiv1shipments) | Create Shipping |
| GET | [/api/v1/shipments/{id}/status](#getapiv1shipments7status) | Get Shipping Status |
| GET | [/api/v1/shipments/{id}/print](#getapiv1shipments1print) | Print Shipping Label |
| PUT | [/api/v1/shipments/{id}/cancel](#putapiv1shipments1cancel) | Cancel Shipping |

***

### [POST]/api/v1/shipments
Create Shipping

#### Headers

```http
Content-Type: "application/json"
Accept: "application/json"
Authroization: "Bearer {{user-token}}"
```

#### RequestBody

```json
{
    "platform": "kwickbox",
    "cod": true,
    "pickup_date": "2023-10-31",
    "sender": {
        "name": "Mohamed Samir",
        "phone": "+201026687240",
        "email": "gm.mohamedsamir@gmail.com",
        "country": "EG",
        "state": null,
        "city": "Cairo",
        "postal_code": null,
        "address_line1": "Cairo",
        "address_line2": null,
        "address_line3": null
    },
    "recipient": {
        "name": "Ahmed Samir",
        "phone": "+201026687240",
        "email": null,
        "country": "EG",
        "state": null,
        "city": "Alexandria",
        "postal_code": null,
        "address_line1": "Alexandria",
        "address_line2": null,
        "address_line3": null
    },
    "items": [
        {
            "title": "Product 1",
            "description": null,
            "quantity": 1,
            "weight": 2.50,
            "unit": "kg",
            "price": 500
        }
    ]
}
```

#### Responses

- 200 Successful response

```json
{
    "message": "Waybill created successfully",
    "data": {
        "id": 22,
        "status": "draft"
    }
}
```

- 422 Validation error response

```json
{
    "message": "The selected platform is invalid.",
    "errors": {
        "platform": [
            "The selected platform is invalid."
        ]
    }
}
```

***

### [GET]/api/v1/shipments/7/status
Get Shipping Status

#### Headers

```http
Accept: "application/json"
Authroization: "Bearer {{user-token}}"
```

#### Responses

- 200 Successful response

```json
{
  "message": "OK",
  "data": {
    "status": "received"
  }
}
```

***

### [GET]/api/v1/shipments/1/print
Print Shipping Label

#### Headers

```http
Accept: "application/json"
Authroization: "Bearer {{user-token}}"
```

#### Responses

- 200 Successful response

```json
{
  "message": "OK",
  "data": {
    "url": "https://fake-url.com/shipment-label.pdf"
  }
}
```

***

### [PUT]/api/v1/shipments/1/cancel
Cancel Shipping

#### Headers

```http
Accept: "application/json"
Authroization: "Bearer {{user-token}}"
```

#### Responses

- 200 Successful response

```json
{
  "message": "OK",
  "data": []
}
```