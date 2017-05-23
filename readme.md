# Multidoc Parser

#### Check out [Multidoc viewer](https://github.com/negreanucalin/multidoc-viewer)
#### Did you say [Laravel?](https://github.com/negreanucalin/multidoc-laravel)

* Parses `*.yaml` files and generates a flat document containing the application's documentation
* Notes
	* No filename convetion required
	* You can organize however you want
	* A sugestion would be to have multiple files:
		* `_project.yaml` - Project description
		* `_categories.yaml` - Menu items and sub-items
		* `user_route.yaml` - Route example
		* `another_route.yaml` - Route example
		
* Project
	* File name `_my_awesome_project.yaml`
```
project:
  name: My Awesome project
  version: 1
  description: Some awesome description
  environments:
    default: https://wwww.myproductionurl.com
    preprod: https://www.mypreproductionurl.com
```
		
* Categories
	* File name `_my_awesome_categories.yaml`
```
categories:
  cat1:
    name: Cat 1
    categories:
      cat2:
        name: Cat 2
  cat3:
      name: Cat 3
  cat4:
      name: Cat 4
```

* Route example
	* File name `user_route.yaml`
```
route:
  name: Some route 1
  description: Some desc 1
  url: '{{environment}}/[:typeEntity][/:page]/comments'
  method: GET
  tags: [tag1, tag2, tag3, tag4, tag5]
  category: cat1
  params:
    - name: typeEntity
      type: uri
      data_type: string
      description: Some desc
      optional: false
      example: posts
    - name: page
      type: uri
      data_type: int
      description: Some desc
      optional: true
      example: 1
```

* Multiple routes example
	* File name `some_routes.yaml`
```
route_list:
  - name: Some route 2
    description: Some desc 2
    url: '{{environment}}/[:typeEntity][/:page]/comments'
    method: GET
    tags: [tag1, tag2, tag3, tag4, tag 5]
    category: cat1
    params:
      - name: typeEntity
        type: uri
        data_type: string
        description: Some desc
        optional: false
        example: posts
      - name: page
        type: uri
        data_type: int
        description: Some desc
        optional: true
        example: 1
  - name: Some route 3
    description: Some desc 3
    url: '{{environment}}/[:typeEntity][/:page]/comments'
    method: GET
    tags: [tag3, tag4]
    category: cat2
  - name: Some route 4
    description: Some desc 4
    url: '{{environment}}/[:typeEntity][/:page]/comments'
    method: GET
    tags: [tag3, tag4]
    category: cat2
    params:
      - name: typeEntity
        type: uri
        data_type: string
        description: Some desc
        optional: false
        example: posts
        possible_values: [posts,test]
```