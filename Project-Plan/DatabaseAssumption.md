# Database Design
![Database Design](https://github.com/Raltyez/Group-7-TR2-2024/assets/143167334/22f0b39a-3c0f-4e24-a8a4-d5b3ba7d4f00)

## Database Design Assumptions

1.	A user can place multiple orders, but each order is placed by a single user.
2.	A user can submit multiple custom design requests, but each custom design request is submitted by a single user.
3.	A user can have multiple entries in their purchase history, but each entry in the purchase history is for a single user.
4.	Each user has one shopping cart, and each shopping cart belongs to one user.
5.	A shopping cart can contain multiple items, but each cart item belongs to a single shopping cart.
6.	An order can contain multiple items, but each order item is part of a single order.
7.	A shirt can be part of multiple order items, but each order item references a single shirt.
8.	A shirt can be part of multiple cart items, but each cart item references a single shirt.
9.	Each order has one payment detail record, and each payment detail record is associated with a single order.
10.	A user can make multiple queries to the virtual assistant, but each query is made by a single user.
