# Simple Video Game Management System API <!-- omit from toc -->

- [Dependencies](#dependencies)
- [Installation](#installation)
- [Usage](#usage)
- [REST API](#rest-api)
  - [Public Routes](#public-routes)
    - [Register New User](#register-new-user)
    - [Login](#login)
  - [Protected Routes](#protected-routes)
    - [Get User details](#get-user-details)
    - [Logout](#logout)
    - [Create Video Game](#create-video-game)
    - [Get Video Games](#get-video-games)
    - [Get Single Video Game](#get-single-video-game)
    - [Update Video Game](#update-video-game)
    - [Delete Video Game](#delete-video-game)
  - [Bugs](#bugs)

## Dependencies

- PHP 8.1
- Composer 2.6

## Installation

1. Clone the Github repository
2. Change directory into the cloned repository
3. Run composer install
4. Run script to generate `.env` file
5. Generate the APP_KEY for this project
6. Create `database.sqlite` file in `video-game-management-system/database` directory

    ```
    git clone https://github.com/mkalbakis/video-game-management-system.git
    cd video-game-management-system
    composer install
    composer run-script post-root-package-install
    php artisan key:generate
    touch database/database.sqlite
    ```

7. Change `.env` file to use the SQLite database

    ```
    DB_CONNECTION=sqlite
    DB_HOST=127.0.0.1
    DB_PORT=3306
    ```

8. Migrate database
9. Serve the application to `http://localhost:8000`

    ```
    php artisan migrate
    php artisan serve
    ```

## Usage

Import `Simple-Video-Game-Management-System-API.postman_collection.json` into Postman to run the requests

## REST API

The API offers a collection of endpoints.

Headers of requests should include the header `Accept:application/json`

### Public Routes

These endpoints are public and don't need authentication

#### Register New User

##### Request <!-- omit from toc -->

`POST /api/register`

##### Parameters <!-- omit from toc -->

- name: `required`
- email: `required, unique`
- password: `required`
- password_confirmation: `required`
- role: `required, [admin|user]`

##### Returns <!-- omit from toc -->

Created user and token

```JSON
{
    "user": {
        "name": "user1",
        "email": "user1@user.com",
        "role": "user",
        "updated_at": "2023-09-18T10:13:41.000000Z",
        "created_at": "2023-09-18T10:13:41.000000Z",
        "id": 6
    },
    "token": "1|efZCjk1neHOIkirkr9Cnxa5GXe5c7uNJRPzHaHZyf4822b0f"
}
```

#### Login

##### Request <!-- omit from toc -->

`POST /api/login`

##### Parameters <!-- omit from toc -->

- email: `required`
- password: `required`

##### Returns <!-- omit from toc -->

```JSON
{
    "user": {
        "id": 1,
        "name": "user1",
        "email": "user1@user.com",
        "email_verified_at": null,
        "role": "user",
        "created_at": "2023-09-18T09:58:58.000000Z",
        "updated_at": "2023-09-18T09:58:58.000000Z"
    },
    "token": "1|efZCjk1neHOIkirkr9Cnxa5GXe5c7uNJRPzHaHZyf4822b0f"
}
```

### Protected Routes

#### Get User details

##### Request <!-- omit from toc -->

`GET /api/user`

##### Authorization <!-- omit from toc -->

Bearer Token: token that is received upon registration or login

##### Returns <!-- omit from toc -->

```JSON
{
    "id": 1,
    "name": "user1",
    "email": "user@user.com",
    "email_verified_at": null,
    "role": "user",
    "created_at": "2023-09-18T09:58:58.000000Z",
    "updated_at": "2023-09-18T09:58:58.000000Z"
}
```

#### Logout

##### Request <!-- omit from toc -->

`POST /api/logout`

##### Authorization <!-- omit from toc -->

Bearer Token: token that is received upon registration or login

##### Returns <!-- omit from toc -->

```JSON
{
    "message": "Logged out"
}
```

#### Create Video Game

##### Request <!-- omit from toc -->

`POST /api/video-games`

##### Parameters <!-- omit from toc -->

- title: `required|unique`
- description: `required`
- release_date: `required|format DD-MM-YYYY`
- genre: `required`

##### Authorization <!-- omit from toc -->

Bearer Token: token that is received upon registration or login

##### Returns <!-- omit from toc -->

Video Game that was created

```JSON
{
    "title": "Game 1",
    "description": "This is game 1",
    "release_date": "01-01-2023",
    "genre": "genre 1",
    "user_id": 1,
    "id": 1
}
```

#### Get Video Games

##### Request <!-- omit from toc -->

`GET /api/video-games`

##### Authorization <!-- omit from toc -->

Bearer Token: token that is received upon registration or login

##### Returns <!-- omit from toc -->

List of video games of current user

```JSON
[
    {
        "id": 1,
        "title": "Game 1",
        "description": "This is game 1",
        "release_date": "01-01-2023",
        "genre": "genre 1",
        "user_id": 1
    }
]
```

#### Get Single Video Game

##### Request <!-- omit from toc -->

`GET /api/video-games/{id}`

##### Authorization <!-- omit from toc -->

Bearer Token: token that is received upon registration or login

##### Returns <!-- omit from toc -->

Video Game with `{id}` if it is owned by current user

```JSON
[
    {
        "id": 1,
        "title": "Game 1",
        "description": "This is game 1",
        "release_date": "01-01-2023",
        "genre": "genre 1",
        "user_id": 1
    }
]
```

#### Update Video Game

##### Request <!-- omit from toc -->

`PUT /api/video-games/{id}`

##### Parameters <!-- omit from toc -->

- title: `optional|unique`
- description: `optional`
- release_date: `optional|format DD-MM-YYYY`
- genre: `optional`

##### Authorization <!-- omit from toc -->

Bearer Token: token that is received upon registration or login

##### Returns <!-- omit from toc -->

Updated Video Game with `{id}` if it is owned by current user

```JSON
[
    {
        "id": 1,
        "title": "Game 1",
        "description": "This is game 1",
        "release_date": "02-02-2023",
        "genre": "genre 2",
        "user_id": 1
    }
]
```

#### Delete Video Game

Simple users can delete only the video games that they own
Admin users can delete any game

##### Request <!-- omit from toc -->

`DELETE /api/video-games/{id}`

##### Authorization <!-- omit from toc -->

Bearer Token: token that is received upon registration or login

##### Returns <!-- omit from toc -->

Deleted message

```JSON
{
    "message": "Video Game deleted"
}
```

### Bugs

- If game title is used by `user1`, `user2` cannot create a video game with the same title
