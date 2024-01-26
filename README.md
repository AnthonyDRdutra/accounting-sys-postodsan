
# Gas Station Accounting System

On WIP project, capable of registering new customers and creating debit tickets for these customers, as well as listing and providing detailed information about each ticket.

On WIP features: 
- Daily cash accounting forms and registry.
  
- Contractors registry and monthly reports.
  
- Monthly finance reports.

# Tecnologies

<p align="left"> <a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="40" height="40"/> </a> <a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/><img src="https://raw.githubusercontent.com/teamedwardforever/Readme-Generator/71f25dd8b98329b168142a6b782a107b75eab178/svg/Skills/Languages/javascript-original.svg" alt="Javascript" width="30" height="30"/> </a> </p>
    
# Funtionalities  
- Client Debt Listing: 
  ![PHP Desktop Chrome 26_01_2024 11_50_01](https://github.com/AnthonyDRdutra/accounting-sys-postodsan/assets/97138694/642f8ada-8db1-4180-bc71-4290b92fc628)
Using the data in the DB (client_books, client_debt ticket), we are able to live search the listing by matching the text input with correspondent data on the database.


- Client Live Search:
![PHP Desktop Chrome 26_01_2024 11_47_49](https://github.com/AnthonyDRdutra/accounting-sys-postodsan/assets/97138694/8845f0c3-e632-4df5-bcd1-cb4a66eb7774)
Using the listing created we filter that list using the text input from the user.

- Quick debt and payment sing up:
  ![PHP Desktop Chrome 26_01_2024 11_48_04](https://github.com/AnthonyDRdutra/accounting-sys-postodsan/assets/97138694/c00261e6-fcfc-4289-9958-912f3300e222)
Using AJAX we read the form and send the desired ID to our script. Using the clients_books table we do the auto-complete text and if we are creating a ticket of a client that wasnt on the client_books table they are added to it.

- Detailed Information and Metrics:
   ![PHP Desktop Chrome 26_01_2024 11_50_13](https://github.com/AnthonyDRdutra/accounting-sys-postodsan/assets/97138694/526bbdaa-a0ee-4f1a-88fc-6b687eda7e52)
We check the data on the client_debt table based on the clinet ID and list every debt in that ID while we present the finance data. 

