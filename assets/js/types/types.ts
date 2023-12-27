export interface User {
    id: number;
    email: string;
    firstName: string;
    lastName: string;
    address: string;
    city: string;
    zipcode: string;
    plainPassword: string;
}

export interface Product {
    id: number;
    name: string;
    price: number;
    description: string;
}