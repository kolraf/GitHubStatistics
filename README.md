Installation
------------

Rename ```.env.example``` to ```.env```

Run in directory <strong>"docker"</strong>:
``` bash
docker compose build
docker compose up -d
docker exec -it project_php composer install
```

Tests
------------
``` bash
docker exec -it project_php composer test
```

Api documentation
------------
``` bash
http://localhost:8080/api/doc
```

Example request body content
------------
``` bash
{
  "repositories": [
    {
      "userName": "symfony",
      "repositoryName": "symfony"
    },
    {
      "userName": "doctrine",
      "repositoryName": "orm"
    }
  ]
}
```

TODO
------------
<ul>
    <li>Error message handling - DTO validation and github api response</li>
    <li>Complete test coverage</li>
</ul>
