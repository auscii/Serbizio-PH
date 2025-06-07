import 'package:flutter/material.dart';
import 'package:serbizio_ph/src/utils/constants/colors.dart';
import 'package:serbizio_ph/src/utils/constants/sizes.dart';
import 'package:serbizio_ph/src/utils/helpers/helper_functions.dart';

class AboutPage extends StatelessWidget {
  const AboutPage({super.key});

  @override
  Widget build(BuildContext context) {
    final dark = HelperFunction.isDarkMode(context);

    return Scaffold(
      appBar: AppBar(
        // backgroundColor: Colors.transparent,
        backgroundColor: dark ? darkModeBackground : whiteColor,
        title: const Text('About'),
      ),
      body: SingleChildScrollView(
        child: Container(
          padding: const EdgeInsets.all(defaultSize),
          child: const Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              SizedBox()
            ],
          ),
        ),
      ),
    );
  }
}
