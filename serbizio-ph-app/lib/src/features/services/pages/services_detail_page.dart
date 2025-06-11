import 'package:flutter/material.dart';
import 'package:gap/gap.dart';
import 'package:icons_plus/icons_plus.dart';
import 'package:serbizio_ph/src/features/services/models/services_model.dart';
import 'package:serbizio_ph/src/utils/constants/colors.dart';
import 'package:serbizio_ph/src/utils/constants/sizes.dart';
import 'package:serbizio_ph/src/utils/helpers/helper_functions.dart';

class ServiceDetailPage extends StatelessWidget {
   const ServiceDetailPage({
    super.key,
    required this.service,
  });

  final ServicesModel service;

  @override
  Widget build(BuildContext context) {
    final dark = HelperFunction.isDarkMode(context);

    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.transparent,
        actions: [
          IconButton(
            onPressed: () async {},
            icon: const Icon(MingCute.share_2_line),
          ),
          const Gap(5.0),
        ],
      ),
      body: SingleChildScrollView(
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
    );
  }

}
