# Desa Wisata Kampuang Minang Nagari Sumpu
This is a Geographic Information System (GIS) Web Application. Created using Codeigniter 4 with Myth/Auth for user authentications.

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](http://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [the announcement](http://forum.codeigniter.com/thread-62615.html) on the forums.

The user guide corresponding to this version of the framework can be found
[here](https://codeigniter4.github.io/userguide/).

## Myth/Auth

[Myth/Auth](https://github.com/lonnieezell/myth-auth) is meant to be a one-stop shop for 99% of your web-based authentication needs with CI4. It includes
the following primary features:

- Password-based authentication with remember-me functionality for web apps
- Flat RBAC per NIST standards, described [here](https://csrc.nist.gov/Projects/Role-Based-Access-Control) and [here](https://pdfs.semanticscholar.org/aeb1/e9676e2d7694f268377fc22bdb510a13fab7.pdf).
- All views necessary for login, registration and forgotten password flows.
- Publish files to the main application via a CLI command for easy customization
- Debug Toolbar integration
- Email-based account verification

## Installation & updates

Using terminal, **run `git clone https://github.com/j03hanafi/desa-wisata-sumpu.git`, go inside the directory with `cd desa-wisata-sumpu`, then `composer install`** to set up Codeigniter 4 framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, uncomment all necessary settings.  
Set `CI_ENVIRONMENT = development` (for development features).  
Set `app.baseURL = 'http://localhost:8080/'`.  
Set any `#DATABASE` settings

Open terminal, run `php spark migrate -all` to create all needed tables.

Run `php spark db:seed BaseSeeder` to fill data into all tables.

Execute `php spark serve` to start application locally.

## Available Users

This application came with few users to use authentication functionality.

| Email                 | Username    | Password   |
|-----------------------|-------------|------------|
| `accuser1@email.com`  | `accuser1`  | `akunaku1` |
| `accuser2@email.com`  | `accuser2`  | `akunaku2` |
| `accuser3@email.com`  | `accuser3`  | `akunaku3` |
| `accuser4@email.com`  | `accuser4`  | `akunaku4` |
| `accowner1@email.com` | `accowner1` | `akunaku5` |
| `accowner2@email.com` | `accowner2` | `akunaku6` |
| `accadmin1@email.com` | `accadmin1` | `akunaku7` |
