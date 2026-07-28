export const user = {
    id: 1,
    name: 'John Doe',
    avatar: null,
};

export const categories = [
    { label: 'Men', href: '/categories/men', description: 'Shirts, denim, tailoring, outerwear' },
    { label: 'Women', href: '/categories/women', description: 'Everyday essentials and statement pieces' },
    { label: 'Footwear', href: '/categories/footwear', description: 'Sneakers, boots, loafers and more' },
    { label: 'Accessories', href: '/categories/accessories', description: 'Bags, jewelry, belts and small goods' },
    { label: 'Home', href: '/categories/home', description: 'Kitchen, storage and interior accents' },
    { label: 'Beauty', href: '/categories/beauty', description: 'Skincare, grooming and personal care' },
];

export const navigationItems = [
    { label: 'Home', href: '/' },
    { label: 'Products', href: '/products' },
    { label: 'Brands', href: '/brands' },
    { label: 'Deals', href: '/deals' },
    { label: 'New Arrivals', href: '/new-arrivals' },
    { label: 'Contact', href: '/contact' },
];

export const footerLinkGroups = [
    {
        title: 'Customer Service',
        links: [
            { label: 'Contact Us', href: '/contact' },
            { label: 'Shipping & Delivery', href: '/shipping' },
            { label: 'Returns', href: '/returns' },
            { label: 'Track Order', href: '/orders/track' },
        ],
    },
    {
        title: 'Information',
        links: [
            { label: 'About Us', href: '/about' },
            { label: 'Privacy Policy', href: '/privacy' },
            { label: 'Terms of Service', href: '/terms' },
            { label: 'FAQ', href: '/faq' },
        ],
    },
];

export const socialLinks = [
    { label: 'Instagram', href: 'https://instagram.com' },
    { label: 'Facebook', href: 'https://facebook.com' },
    { label: 'X', href: 'https://x.com' },
    { label: 'YouTube', href: 'https://youtube.com' },
];
