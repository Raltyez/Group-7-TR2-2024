# CP 3407 Group-7 Project Title: Custom Shirt Designer

<details>
<summary>
Project Description
</summary>
  
  ## Project Description
Custom Shirt Designer is an innovative website that allows users to design and purchase custom shirts tailored to their preferences. Users can select the size and color for the shirt base, create or choose specific designs, and complete the purchase online. The platform ensures a smooth user experience from customization to delivery, featuring secure online payment and efficient order delivery. Additionally, it offers a dedicated section for users to view their past orders and track current ones. The integrated virtual assistant provides real-time assistance with design choices, order processes, and any queries, making Custom Shirt Designer a convenient and personalized solution for custom apparel shopping.
</details>

<details>
<summary>
  Justification
</summary>
  
## Justification
The demand for personalized apparel is rapidly increasing in today's market, driven by consumers' desire for unique self-expression. Traditional retail stores often lack the variety and customization options that modern customers seek. Additionally, the convenience of online shopping has become a significant factor in purchasing decisions. Market research indicates a growing trend towards online customization platforms for clothing, highlighting the need for innovative ICT solutions in this sector. Existing ICT solutions in the market offer limited customization options and may not provide an intuitive user experience. Many platforms lack integration with virtual assistants, which can enhance user engagement and satisfaction. Therefore, there is a clear opportunity to develop a comprehensive custom shirt designing website that caters to the evolving needs of consumers.
</details>

<details>
<summary>
  Goals
</summary>
  
## Goals
The primary goal of the Custom Shirt Designer project is to develop a user-friendly website that enables customers to design and purchase custom shirts with ease. Project deliverables consist of:
1. User Interface: Design an intuitive and visually appealing interface that guides users through the customization process.
2. Customization Options: Implement a varied range of customization features, covering shirt size, color, and personalized design options.
3. Virtual Assistant Integration: Integrate a virtual assistant to provide real-time support and assistance to users throughout the design and ordering process.
4. Secure Payment Gateway: Implement a secure online payment system to facilitate seamless transactions.
5. Order Tracking: Develop a system for users to track the status of their orders and view past purchases.
</details>

<details>
<summary>
  Instructions
</summary>
  
## Project Setup Instructions

### 1. Install Necessary Software
1. **VS Code**: Download and install [VS Code](https://code.visualstudio.com/download) or another code editor of your choice.
2. **Composer**: Download and install [Composer](https://getcomposer.org/download/) for dependency management and to use tools like PHPMailer.
3. **XAMPP**: Download and install [XAMPP](https://www.apachefriends.org/download.html) for a local web server environment.

### 2. Configure XAMPP
1. Open the XAMPP Control Panel.
2. Click 'Start' for both Apache and MySQL. 
3. Ensure that ports 80, 443, and 3306 are not being used by other applications.
   ![XAMPP Control Panel](https://github.com/user-attachments/assets/67dda34b-3e17-4ac1-b47f-0387654ef845)

### 3. Set Up the Database
1. Open a web browser and go to `localhost`.
2. In the website header, click on 'phpMyAdmin'.
   ![phpMyAdmin](https://github.com/user-attachments/assets/b35e144f-fdb8-4c19-9523-f1bbbb8355ea)
3. Create a new database named `users` and click 'Create'.
   ![Create Database](https://github.com/user-attachments/assets/82d73785-89d5-4984-be8d-a781a8de32ac)
4. Open the SQL tab in the `users` database.
5. Copy the SQL code from [this link](https://github.com/Raltyez/Group-7-TR2-2024/blob/main/Code/sql_code) and paste it into the SQL query box. Click 'Go'.
   ![SQL Query](https://github.com/user-attachments/assets/e7be1db4-3bae-4da4-bce8-2cd834a3300e)
6. Verify that the attributes are as shown below.
   ![Database Attributes](https://github.com/user-attachments/assets/c95524d1-d979-4148-a845-e4a295fa56a0)
7. Click on the `product` database, open the SQL tab, and paste the SQL code from [this link](https://github.com/Raltyez/Group-7-TR2-2024/blob/main/Code/product_sql_code). Click 'Go'.

### 4. Set Up the Project Folder
1. Create a new folder named `comitop` in the following directory: `This PC > OS (C:) > xampp > htdocs`.
2. Open VS Code and navigate to the `comitop` folder.
3. Paste all the code from [this repository](https://github.com/Raltyez/Group-7-TR2-2024/tree/main/Code) into the `comitop` folder.

### 5. Verify the Setup
1. In your web browser, go to `http://localhost/comitop` to see if the project is running correctly.
2. Ensure that the database and project files are correctly set up and functioning as expected.

If you encounter any issues, refer to the installation guides of the respective software or seek help from relevant community forums.

</details>
