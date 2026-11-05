USE bcac591_lab;

INSERT INTO candidates (name)
SELECT 'Candidate A' WHERE NOT EXISTS (SELECT 1 FROM candidates WHERE name='Candidate A');
INSERT INTO candidates (name)
SELECT 'Candidate B' WHERE NOT EXISTS (SELECT 1 FROM candidates WHERE name='Candidate B');

INSERT INTO products (name, category, description, price)
SELECT 'Notebook', 'Stationery', 'A ruled notebook for everyday notes.', 65.00
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Notebook');
INSERT INTO products (name, category, description, price)
SELECT 'Pen Set', 'Stationery', 'A set of blue ink pens.', 45.00
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Pen Set');
INSERT INTO products (name, category, description, price)
SELECT 'USB Drive', 'Electronics', 'A USB storage device for file transfer.', 399.00
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='USB Drive');

INSERT INTO events (title, event_date, description)
SELECT 'PHP Lab Workshop', DATE_ADD(NOW(), INTERVAL 7 DAY), 'A sample event for testing registration.'
WHERE NOT EXISTS (SELECT 1 FROM events WHERE title='PHP Lab Workshop');
