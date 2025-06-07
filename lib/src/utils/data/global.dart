import 'package:flutter/material.dart';

class Global {

  static final dynamic filters = [
    {"category": "Healthcare", "icon": Icons.health_and_safety},
    {"category": "Education", "icon": Icons.school},
    {"category": "Food & Beverage", "icon": Icons.food_bank_sharp},
    {"category": "Construction", "icon": Icons.construction},
    {"category": "Transportation", "icon": Icons.emoji_transportation},
    {"category": "Financial Services", "icon": Icons.monetization_on},
    {"category": "Event Planning", "icon": Icons.event},
    {"category": "IT & Software Development", "icon": Icons.developer_mode_outlined},
    {"category": "Real Estate", "icon": Icons.house_outlined},
    {"category": "Cleaning Services", "icon": Icons.clean_hands},
    {"category": "Security Services", "icon": Icons.security},
    {"category": "Automotive Services", "icon": Icons.car_crash},
  ];

  static List<String> images = [
    "https://images.unsplash.com/photo-1626606076701-cf4ae64b2b03?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1332&q=80",
    "https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Z29hJTIwYmVhY2h8ZW58MHx8MHx8fDA%3D&w=1000&q=80"
  ];

  static bool isoffline = true;

}