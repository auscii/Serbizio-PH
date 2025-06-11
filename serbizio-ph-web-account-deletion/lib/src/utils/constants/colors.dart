import 'package:flutter/material.dart';

const primaryColor = Color(0xFF7045F2);
const secondaryColor = Color.fromARGB(255, 146, 114, 243); //Color(0x367045F2);
const otherColor = Color.fromARGB(255, 130, 94, 240); //Color(0x367045F2);
const whiteColor = Colors.white;
const blackColor = Colors.black;
const darkModeBackground = Color(0xFF303030);
const textColor1 = Color(0xFF454545);
const textColor2 = Color(0xFF767676);
const borderColor = Color(0xFFE0E0E0);
const activeGreenText = Color(0xFF50C878);
const activeGreen = Color(0x3650C878);
const redColor = Color(0xFFF44336);
const redColorBackground = Color(0x36F44336);

MaterialColor createMaterialColor(Color color) {
  List strengths = <double>[.05];
  final swatch = <int, Color>{};
  final int r = color.red, g = color.green, b = color.blue;

  for (int i = 1; i < 10; i++) {
    strengths.add(0.1 * i);
  }
  for (var strength in strengths) {
    final double ds = 0.5 - strength;
    swatch[(strength * 1000).round()] = Color.fromRGBO(
      r + ((ds < 0 ? r : (255 - r)) * ds).round(),
      g + ((ds < 0 ? g : (255 - g)) * ds).round(),
      b + ((ds < 0 ? b : (255 - b)) * ds).round(),
      1,
    );
  }
  return MaterialColor(color.value, swatch);
}