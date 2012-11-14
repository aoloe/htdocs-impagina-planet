scribus-planet
==============

create a a simplepie based planet for scribus

TODO:

- create some nice HTML + CSS
- move the feed list to an external csv file<br>
  (data/cache + data/feed.csv ?)<br>
  feed, url, label[,options]*<br>
  where options = option_label,option_value<br>
  (a.l.e: i have some code, i'm going to publish soon for the mapping of csv files to an entity)
- check if the caching mechanism of simple pie is enough or if we need something more
- add further types of feeds / use better or multiple services for the existing ones
- add the original BSD license in the simplepie directory
- remove the .svn directories in the simplepie directory
- for specific sources, is it possible to get only the posts with specific tags? (#scribus)
- add the posts from the commit mailing list?
- add the threads from the mailing list? (not each mail, just the first for each thread)
- add some links to the library and sources used (markdown, simplepie, wallflux, ...)