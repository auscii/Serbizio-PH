import 'package:flutter/material.dart';
import 'package:gap/gap.dart';
import 'package:get/get.dart';
import 'package:icons_plus/icons_plus.dart';
import 'package:serbizio_ph/src/features/services/models/services_model.dart';
import 'package:serbizio_ph/src/features/services/pages/services_detail_page.dart';
import 'package:serbizio_ph/src/utils/constants/sizes.dart';
import 'package:serbizio_ph/src/utils/constants/colors.dart';
import 'package:serbizio_ph/src/utils/helpers/helper_functions.dart';

class ServiceCard extends StatelessWidget {
  const ServiceCard({
    super.key,
    required this.service,
  });

  final ServicesModel service;

  @override
  Widget build(BuildContext context) {
    final dark = HelperFunction.isDarkMode(context);

    return Padding(
      padding: const EdgeInsets.only(bottom: 5.0),
      child: GestureDetector(
        onTap: () {Get.to(() => ServiceDetailPage(service: service));},
        child: Card(
          elevation: 0,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(10.0),
            side: BorderSide(color: dark ? textColor1 : borderColor, width: 1),
          ),
          child: Container(
            padding: const EdgeInsets.all(defaultSize),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text("Service Detail Test", style: Theme.of(context).textTheme.headlineSmall),
                const Gap(10.0),
                // Badge(label: service.parkingStatus ? const Text('Open') : const Text('Close'), textColor: service.parkingStatus ? activeGreenText : redColor, backgroundColor: service.parkingStatus ? activeGreen : redColorBackground),
                const Gap(20.0),
                Row(
                  children: [
                    Icon(MingCute.map_pin_line, color: dark ? whiteColor : textColor1),
                    const Gap(5.0),
                    const Expanded(
                      child: Text(
                        "Test",
                        maxLines: 3,
                        softWrap: true,
                      ),
                    ),
                  ],
                ),
                const Gap(10.0),
                Row(
                  children: [
                    Icon(MingCute.car_3_line, color: dark ? whiteColor : textColor1),
                    const Gap(5.0),
                    const Text.rich(
                      TextSpan(text: "Available: ",
                        children: [
                          TextSpan(text: "Not counted", style: TextStyle(fontWeight: FontWeight.w600)),
                        ],
                      ),
                    ),
                  ],
                ),
                const Gap(10.0),
                Row(
                  children: [
                    Icon(Icons.nfc_outlined, color: dark ? whiteColor : textColor1),
                    const Gap(5.0),
                    const Text('RFID: '),
                    const Badge(label: Text('Available'), textColor: activeGreenText),
                  ],
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
