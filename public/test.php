{
  "query": {
    "bool": {
      "should": [
        {
          "term": {
            "content": {
              "value": "test",
              "boost": 2.0
            }
          }
        }
      ]
  },
 "fields" : [ "content^3", "keyword" ]
  }
}
