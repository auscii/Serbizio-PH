import 'package:flutter/material.dart';
import 'package:serbizio_ph_web_privacy_policy/src/utils/constants/colors.dart';

class AppBarThemeData {
  static AppBarTheme lightAppBarTheme = const AppBarTheme(
    backgroundColor: Colors.transparent,
    iconTheme: IconThemeData(color: blackColor),
    titleTextStyle: TextStyle(color: blackColor, fontWeight: FontWeight.bold, fontSize: 16),
    centerTitle: true,
    elevation: 0,
  );

  static AppBarTheme darkAppBarTheme = const AppBarTheme(
    backgroundColor: Colors.transparent,
    iconTheme: IconThemeData(color: whiteColor),
    titleTextStyle: TextStyle(color: whiteColor, fontWeight: FontWeight.bold, fontSize: 16),
    centerTitle: true,
    elevation: 0,
  );
}