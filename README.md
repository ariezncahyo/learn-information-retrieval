
# Learn Information Retrieval

it's part of studying Intelligent Information Retrieval in university

## Download

1. You can fork / clone / download as ZIP on this Github repo.
2. Or you can download from Google Drive [here](https://drive.google.com/file/d/1-EYkDzXRp9qz3ucM6DZZ6oCMP1_-UlmZ/view?usp=sharing)

## Getting Started

Download or fork this project into your htdocs folder (for Windows user) or /var/www/ (for Linux user).
Run your PHP and MySQL, then go to this [url](http://localhost/learn-information-retrieval/) or in your localhost url. Choose project you want to use. For example you want to use tokenization, then go to [here](http://localhost/learn-information-retrieval/tokenization). If you are using stemming-nazief, make sure to follow the readme there.

What is Information Retrieval? Described in Bahasa Indonesia, [here](https://docs.google.com/document/d/1Dte-Tahrr1pswB-Co10RppwzfcDD4a1kqRZRzNiZJQo/edit?usp=sharing)


### Prerequisites

What things you need to install the software and how to install them
Before you using this project, there are requirements that has to be fulfilled: 
```
1. for php-ai project, you have to install PHP version >= 7.1 [read here](https://github.com/php-ai/php-ml)
2. for stemming-nazief project, you have to install MySQL.
```

## About

* [crawling-bukalapak](https://github.com/ridhof/learn-information-retrieval/tree/master/crawling-bukalapak) is using Simple HTML DOM to crawl product query on [Bukalapak](https://www.bukalapak.com/). It will show you the dicounted price of product you searched instead of the normal price. There's no requirement to run this project.
* [crawling-kompas](https://github.com/ridhof/learn-information-retrieval/tree/master/crawling-kompas) also using Simple HTML DOM to crawl newest articles on [Kompas](https://www.kompas.com/). There's no requirement to run this project.
* [php-ai-canberra-hamming](https://github.com/ridhof/learn-information-retrieval/tree/master/php-ai-canberra-hamming) is a similarity methods that runs Canberra and Hamming methods using PHP-AI/PHP-ML library. The requirement to run the project is using PHP 7.2.* or higher. There is also spreadsheet version of this project to validate the value [here in Bahasa Indonesia](https://docs.google.com/spreadsheets/d/1ThD8XPIvNAlxnvZLNHKBVt8jgY5gpsfc_-1xQU5AHiI/edit?usp=sharing)
* [php-ai-similarity](https://github.com/ridhof/learn-information-retrieval/tree/master/php-ai-similarity) is a similarity methods too but runs Euclidean, Manhattan, Chebyshev and Minkowski methods using PHP-AI/PHP-ML library. The requirement to run the project is using PHP 7.2.* or higher. There is also spreadsheet version of this project to validate the value [here in Bahasa Indonesia](https://docs.google.com/spreadsheets/d/1ThD8XPIvNAlxnvZLNHKBVt8jgY5gpsfc_-1xQU5AHiI/edit?usp=sharing)
* [sastrawi-stopwordremover](https://github.com/ridhof/learn-information-retrieval/tree/master/sastrawi-stopwordremover) is a stemming methods to to preprocessing and indexing of query using sastrawi, the popular Indonesian stemming library. There's no requirement on using this project.
* [stemming-nazief](https://github.com/ridhof/learn-information-retrieval/tree/master/stemming-nazief) is the same as sastrawi-stopwordremover, it used for stemming methods but not as good as Sastrawi, there are still lot of things are miss. To run this project, you must run your MySQL then input value of your username, password, database name, host name on index.php file. Sql file is provided inside the project, inside SQL folder.
* [tokenization](https://github.com/ridhof/learn-information-retrieval/tree/master/tokenization) is a tokenization methods on queries after being preprocessed. It's not using any library to do the tokenization. There are Unigram, Bigram, and Trigram tokenization. There's no requirements on using this project. 

## Built With

* [PHP-ML](https://github.com/php-ai/php-ml) - Machine Learning library for PHP
* [Simple HTML DOM](http://simplehtmldom.sourceforge.net/) - Crawling
* [Sastrawi](https://github.com/sastrawi/sastrawi) - High quality stemmer library for Indonesian Language (Bahasa)
* [Algoritma Stemming Nazief Adriani](https://github.com/ilhamdp10/algoritma-stemming-nazief-adriani) - Stemming and StopWordRemover library

## Contributing

Feel free to give an issue based on any problem you face when using this repo. Any suggestion is widely opened. Please do Pull Request to make this repo more useful. Thank you!

## Acknowledgments

* Thanks to my University.
* All of the documentation.
* All of the examples of usages.
