# API Reference
ThumpNet's API is based on a HTTP/REST API for general operations. The most common use is to retrieve level metadata.

#### Base URL
```
https://thumpnet.anthofoxo.xyz/api/v1
```

## Authentication
Authenticating with the ThumpNet API may be done with a API key. This is required for some endpoints.

`401 Unauthorized` is returned when attempting to access these endpoints.

#### Example Bearer Token Authorization Header
```
Authorization: 6c50ec95-8c1c-4916-9d12-7005b7ad8205
```

## Nullable / Optional / Expandable Fields
* Expandable fields have types prefixed with a dollar sign.
* Expandable fields are more specifically of type `(int|type)`.
* Resource fields that may contain a `null` value have types that are suffixed with a question mark.
* Resource fields that are optional have names that are prefixed with a question mark.

| Field                                   | Type     |
| --------------------------------------- | -------- |
| ?optional_field                         | string   |
| nullable_field                          | string?  |
| ?optional_and_nullable_field            | string?  |
| ?expandable_optional_field              | $string  |
| expandable_nullable_field               | $string? |
| ?expandable_optional_and_nullable_field | $string? |

## Custom Types
The API has some custom types to make note of how it's expected to be used.

| Type      | Base Type | Description              |
| ----------| --------- | ------------------------ |
| dl        | string    | Entry into the dl system |
| timestamp | string    | UTC Timestamp            |


## The `level` endpoint
Used to fetch a level list and level information.

#### Request object
| Field     | Type      | Default     | Description           |
| --------- | --------- | ----------- | --------------------- |
| ?offset   | int?      | 0           | Offset into datablock |
| ?limit    | int?      | 10          | Max levels to return  |
| ?expand   | string[]? | null        | Expand list           |
| ?filter   | string?   | ""          | Level search terms, leave empty to select everything |
| ?sort     | string?   | <See below> | Sorting method                                       |
| ?sort_dir | string?   | "asc"       | Sorting direction, "asc" or "desc"                   |

#### Sorting methods
* `relevance` - Sort to best match the search terms
* `alphabetical` - Sort alphabetically
* `timestamp` - Sort by upload date
* `difficulty` - Sort by difficulty

#### Response object
| Field     | Type      | Description        |
| --------- | --------- | ------------------ |
| count     | int       | Number of levels   |
| ?levels   | $level[]? | Fetched levels     |
| ?warnings | string[]? | Generated warnings |

#### Level Object
| Field        | Type      | Description         |
| ------------ | --------- | ------------------- |
| id           | int       | Level id            |
| uploader     | $user     | Level uploader      |
| name         | string    | Level name          |
| ?cdn         | dl?       | DL Reference        |
| (Removed)?content     | dl?       | DL Reference        |
| (Removed)?thumbnail   | dl?       | DL Reference        |
| ?description | string?   | Level description   |
| ?authors     | $user[]?  | Authors             |
| ?difficulty  | int?      | Level difficulty    |
| ?bpm         | int?      | Level bpm           |
| ?sublevels   | int?      | Number of sublevels |
| ?song        | string?   | Song used in level  |
| timestamp    | timestamp | Upload timestamp    |

#### User Object
| Field       | Type   | Description |
| ----------- | ------ | ----------- |
| id          | int    | User id     |
| username    | string | Username    |



## Object expansion field
Some object are able to be expanded. Meaning be converted from an id, into their accociated object.
* When `resolve.includes("level")`, Level metadata will be fetched.
* When `resolve.includes("user")`, User metadata will be fetched.

## Downloading
Downloads may be performed using a request like this. `http://domain.com/cdn/uuid`.
* `domain.com` This is where you're accessing the api.
* `uuid` Is either the `content` or `thumbnail` fields of level metadata.

* Content is *ALWAYS* in a `.zip` format.
* Thumbnails are *ALWAYS* in a `.png` format.