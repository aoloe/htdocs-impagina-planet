# Scribus Planet

A simplepie based planet for scribus

TODO:

- create some nice HTML + CSS
- move the feed list to an external csv file  
  (data/cache + data/feed.csv ?)  
  `feed, url, label[,options]*`  
  where `options = option_label,option_value`  
  (a.l.e: i have some code, i'm going to publish soon for the mapping of csv files to an entity)
- check if the caching mechanism of simple pie is enough or if we need something more
- add further types of feeds / use better or multiple services for the existing ones
- for specific sources, is it possible to get only the posts with specific tags? (#scribus)

other todos which might or not be already implemented:

- add a filter for email (\n\n -> </p><p> + \n -> br)
- clean up the heuristics for reading the author
- add further types of feeds / use better or multiple services for the existing ones
- add some credits (links) for the libraries and sources used (markdown, simplepie, wallflux, ...)
- add a next / preview post in the item popup
- add a "read more" / "read in context" link at the end of each entry (the link "under" the title is not enough)
