# Thumpnet Public Api v1.0

The ThumpNet Api expects `POST` requests with `JSON` bodies.
The Api will respond with a `JSON` object.

## Version control
Follows [Semantic Versioning 2.0.0](https://semver.org/).
The api is currently on version `0.1.0`.

## HTTP Status Codes
The api may respond with different status codes.
* `200 OK`. Everything worked as expected. There is content in the response body.
* `400 Bad Request`. The request was invalid. There is more detail in the response body.
* `500 Internal Server Error`. The server encountered an error. The reply is undefined.

## The `com` object
Every request and response has a `com` object.
This gives us a means of communication about expected versions, errors and features.

For the examples on this page. The `com` object is only shown if it illustates something useful to us. If omitted in examples.
* Assume requests have `com.accept = ["0.1.0"]`.
* Assume responses have `com.version = "0.1.0"`

### Requests
```json
"com": {
  // List of versions to accept, ordered by priority
  // If the server cannot fulfill this, an error will be returned.
  "accept": ["0.1.0"]
}
```

### Responses
```json
"com": {
  "version": "0.1.0" // What version was chosen
}
```

### Errors
`400 Bad Request`
```json
"com": {
  "error": "ErrorCode: Some error description"
}
```
### Example
```json
{ // Main request/response object
    "com": { // Com object
        "accept": ["0.1.0"]
    }
}
```

## Endpoints
Endpoint are located in `/endpoint/`.
For example to access the `level` endpoint. You'll make requests to `/endpoint/level/`.

## `/info/` endpoint
This endpoint is used to query general information about the server.

This endpoint does not use the `com` object.

Request: `GET /info/`


Response: `200 OK`
```json
{
  "accept": ["0.1.0"], // What the server accepts
  "dl": "cdn" // Where to find level & user data
}
```

## `/level/` endpoint
Used to fetch a level list and level information.

Request: `POST /level/`
```json
{
  // Get the newest level
  "offset": 0,
  "limit": 1
}
```
Reply: `200 OK`
```json
{
  "count": 51, // Total number of levels
  "levels": [ 20 ]
}
```

The api expects you to have some sort of client-side cache. However is not required. To fill out the metadata. Use `resolve`.

Request: `POST /level/`
```json
{
  // Get the newest level
  "offset": 0,
  "limit": 1,
  "resolve": ["user", "level"] // Resolve level and user ids to objects
}
```
Reply: `200 OK`
```json
{
  "count": 51, // Total number of levels
  "levels": [
    { // Expanded with resolve.level
      "id": 20,
      "uploader": { // Expanded with resolve.user
        "id": 1,
        "username": "SuperCoolUserName",
      },
      "name": "LevelName",
      "content": "00000000-0000-4000-0000-000000000000",
      ...
    }
  ]
}
```

## Downloading
Downloads may be performed using a request like this. `http://domain.com/dl/uuid`.
* `domain.com` This is where you're accessing the api.
* `dl` This is retrived with `/api`. The response will have a `dl` field.
* `uuid` Is either the `content` or `thumbnail` fields of level metadata.

* Content is *ALWAYS* in a `.zip` format.
* Thumbnails are *ALWAYS* in a `.png` format.