# Auth

## Entities

### Organisation

Organisations are companies.
They have a name, a UUID V4 with a prefix of `org-` and a number of members, each of which can have different roles.

#### Organisation Role

Roles exist between a user and an organisation and can consist of `member`, `admin`.

### User

Users have an id which is a UUID V4 with a prefix of `usr-`.
Users have a username, email address and password.

### JWT Token

JWT tokens are created when a user is authenticated and are sent via the UI to all other backend services so as they know who is logged in, and so as they know what permissions are allowed.

#### Structure

```
{
	"sub": "usr-111-111-111-111",
	"orgs": [
		"org-222-222-222-222",
		"org-333-333-333-333"
	],
	"ttl": "1520197820",
	"perms": {
		"resourceName": {
			"action": {
				"restrictionName": [
					"val1",
					"val2"
				],
			}
		}
	}
}
```

- If a resourceName or action is missing from the perms, then access is denied.
- If a resource name and action exists, but there are no restrictions then access is allowed.
- If a resource name and action exists, and there are restrictions, you should check against all restrictions in and `AND` context.

For example, the following permissions...

- A user can read all problems
- A user can create problems for the organisations "org-111-111-111-111" and "org-222-222-222-222"
- A user can update problems for the organisations "org-111-111-111-111" and "org-222-222-222-222"
- A user can delete problems for the organisations "org-111-111-111-111" and "org-222-222-222-222"
- A user can read all organisations
- A user can create an organisation
- A user cannot update or delete any organisations

```
{
	"sub": "usr-111-111-111-111",
	"orgs": [
		"org-222-222-222-222",
		"org-333-333-333-333"
	],
	"ttl": "1520197820",
	"perms": {
		"organisation": {
			"read": {},
			"create": {}
		},
		"problem": {
			"read": {},
			"create": {
				"organisationId": [
					"org-222-222-222-222",
					"org-333-333-333-333"
				]
			},
			"update": {
				"organisationId": [
					"org-222-222-222-222",
					"org-333-333-333-333"
				]
			},
			"delete": {
				"organisationId": [
					"org-222-222-222-222",
					"org-333-333-333-333"
				]
			}
		}
	}
}

