import 'package:flutter/material.dart';
import 'package:gap/gap.dart';
import 'package:serbizio_ph/src/utils/constants/colors.dart';
import 'package:serbizio_ph/src/utils/constants/sizes.dart';
import 'package:serbizio_ph/src/utils/helpers/helper_functions.dart';

import '../../../utils/constants/images.dart';
import '../../home/components/team_comp.dart';

class AboutPage extends StatelessWidget {
  const AboutPage({super.key});

  @override
  Widget build(BuildContext context) {
    final dark = HelperFunction.isDarkMode(context);

    return Scaffold(
      appBar: AppBar(
        // backgroundColor: Colors.transparent,
        backgroundColor: dark ? darkModeBackground : whiteColor,
        title: const Text(
          'About',
          style: TextStyle(
            fontFamily: 'Epilogue',
            fontSize: 24.0,
            fontWeight: FontWeight.bold
          )
        ),
      ),
      body: SingleChildScrollView(
        child: Container(
          padding: const EdgeInsets.all(defaultSize),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              Container(
                padding: EdgeInsets.zero,
                width: 350,
                child: Image.asset(
                  appLogo,
                  fit: BoxFit.fill,
                  // height: 200,
                  // width: 220
                ),
              ),
              const Gap(5.0),
              Column(
                mainAxisAlignment: MainAxisAlignment.start,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Container(
                    margin: const EdgeInsets.symmetric(horizontal: 20),
                    child: const Text(
                      "Serbizio Instant Services connects you with trusted service providers and companies for all your needs, from household help to restaurant services, construction, and BPO. Whether you're seeking reliable professionals or offering your expertise, our platform links service providers with reputable companies, ensuring quality and trust on both sides. Explore our app to discover and hire the best services or showcase your skills to top employers at your fingertips.",
                      textAlign: TextAlign.justify,
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.normal,
                      ),
                    ),
                  ),
                ],
              ),
              const Gap(30.0),
              Container(
                margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),
                child: const Text(
                  "Our Team",
                  style: TextStyle(
                    fontSize: 24,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ),
              const Gap(10.0),
              const Row(
                crossAxisAlignment: CrossAxisAlignment.center,
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  TeamComp(
                    teamProfileImageURL: networkPathURLprofileCEOandCTO,
                    teamName: "Sean Walden Reyes",
                    teamMotto: "Committed to driving change and pushing boundaries to achieve excellence in all aspects of our business.",
                    teamPosition: "CEO & CTO",
                  ),
                  TeamComp(
                    teamProfileImageURL: networkPathURLprofileCMO,
                    teamName: "Casey Dowling",
                    teamMotto: "My vision is to foster a culture of innovation that empowers our team to create impactful solutions for our clients.",
                    teamPosition: "CMO",
                  ),
                  TeamComp(
                    teamProfileImageURL: networkPathURLprofileCFO,
                    teamName: "Julius Alexander Reyes",
                    teamMotto: "Believing in the power of collaboration, I strive to connect ideas and people to build a stronger, more resilient company.",
                    teamPosition: "CFO",
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}
