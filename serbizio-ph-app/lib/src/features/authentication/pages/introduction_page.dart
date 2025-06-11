import 'package:flutter/material.dart';

class IntroductionPage extends StatelessWidget {
  const IntroductionPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(color: Colors.white);

    // return Scaffold(
    //   body: IntroductionScreen(
    //     scrollPhysics: const BouncingScrollPhysics(),
    //     pages: [
    //       PageViewModel(
    //         titleWidget: Center(
    //           child: Text(
    //             'Real-time service count availability',
    //             style: Theme.of(context).textTheme.headlineMedium,
    //             textAlign: TextAlign.center,
    //           ),
    //         ),
    //         body:
    //           'Get an alert notifications and information on service availability with the RFID technology',
    //         image: Center(
    //           child: Image(
    //             image: const AssetImage(introOne),
    //             height: size.height * 0.4,
    //           ),
    //         ),
    //         decoration: PageDecoration(
    //           imagePadding: const EdgeInsets.only(top: 50.0),
    //           titlePadding: const EdgeInsets.only(bottom: 10.0),
    //           bodyTextStyle: TextStyle(fontSize: 14.0, color: dark ? whiteColor : textColor1),
    //         ),
    //       ),
    //       PageViewModel(
    //         titleWidget: Center(
    //           child: Text(
    //             'Find nearest service inside UiTM',
    //             style: Theme.of(context).textTheme.headlineMedium,
    //             textAlign: TextAlign.center,
    //           ),
    //         ),
    //         body: 'Find the nearest service inside UiTM with the interactive map geotagging and geolocation',
    //         image: Center(
    //           child: Image(
    //             image: const AssetImage(introTwo),
    //             height: size.height * 0.4,
    //           ),
    //         ),
    //         decoration: PageDecoration(
    //           imagePadding: const EdgeInsets.only(top: 50.0),
    //           titlePadding: const EdgeInsets.only(bottom: 10.0),
    //           bodyTextStyle: TextStyle(fontSize: 14.0, color: dark ? whiteColor : textColor1),
    //         ),
    //       ),
    //       PageViewModel(
    //         titleWidget: Center(
    //           child: Text(
    //             'Share available service information',
    //             style: Theme.of(context).textTheme.headlineMedium,
    //             textAlign: TextAlign.center,
    //           ),
    //         ),
    //         body: 'Share the available service information with your friends',
    //         image: Center(
    //           child: Image(
    //             image: const AssetImage(introThree),
    //             height: size.height * 0.4,
    //           ),
    //         ),
    //         decoration: PageDecoration(
    //           imagePadding: const EdgeInsets.only(top: 50.0),
    //           titlePadding: const EdgeInsets.only(bottom: 10.0),
    //           bodyTextStyle: TextStyle(fontSize: 14.0, color: dark ? whiteColor : textColor1),
    //         ),
    //       ),
    //     ],
    //     onDone: () {
    //       Get.to(() => const WelcomePage());
    //     },
    //     onSkip: () {
    //       Get.to(() => const WelcomePage());
    //     },
    //     showSkipButton: true,
    //     skip: Text(
    //       "Skip",
    //       style: TextStyle(
    //         color: dark ? whiteColor : textColor1,
    //         fontWeight: FontWeight.bold,
    //       ),
    //     ),
    //     next: Icon(Icons.arrow_forward_outlined, color: dark ? whiteColor : primaryColor),
    //     done: Text(
    //       "Done",
    //       style: TextStyle(
    //         color: dark ? whiteColor : primaryColor,
    //         fontWeight: FontWeight.bold,
    //       ),
    //     ),
    //     dotsDecorator: DotsDecorator(
    //       size: const Size.square(10.0),
    //       activeSize: const Size(20.0, 10.0),
    //       color: textColor2,
    //       activeColor: primaryColor,
    //       spacing: const EdgeInsets.symmetric(horizontal: 3.0),
    //       activeShape: RoundedRectangleBorder(
    //         borderRadius: BorderRadius.circular(25.0),
    //       ),
    //     ),
    //   ),
    // );
  }
}
