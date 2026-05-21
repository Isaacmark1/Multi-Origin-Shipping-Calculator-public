# Multi-Origin Shipping Calculator Extracts for Showcase

A custom WooCommerce shipping calculator designed for stores that ship products from multiple origins, vendors, warehouses, suppliers, or countries.

The plugin calculates shipping using:

- Product origin zones
- Destination zones
- Actual weight
- Volumetric weight
- Chargeable weight
- Weight-tier pricing
- Rate-per-kg shipping
- Handling fees
- Fuel surcharge
- Profit margin

---

# Why I Built This

Many WooCommerce stores source products from multiple suppliers, warehouses, or countries. Standard WooCommerce shipping methods do not easily support origin-based shipping calculations, especially when multiple products in the same cart ship from different locations.

This project solves that problem by grouping cart items by shipping origin and calculating shipping dynamically based on configurable freight logic.

---

# Key Features

## Multi-Origin Shipping

Products can ship from different origins such as:

- China suppliers
- UK warehouse
- Local vendors
- Regional warehouses
- International suppliers

---

## Destination Zone Pricing

Shipping can be calculated based on customer delivery zones such as:

- Western Europe
- Southern Europe
- Eastern Europe
- Local delivery zones
- Regional delivery zones

---

## Chargeable Weight Logic

The plugin compares:

- Actual weight
- Volumetric weight

and uses the higher value as the chargeable weight.

### Formula

```text
Chargeable Weight = Max(Actual Weight, Volumetric Weight)
