import 'package:flutter/material.dart';
import 'package:serbizio_ph/src/utils/constants/colors.dart';
import 'package:serbizio_ph/src/utils/helpers/helper_functions.dart';
// import 'package:gap/gap.dart';
// import 'package:get/get.dart';
// import 'package:google_maps_flutter/google_maps_flutter.dart';
// import 'package:sliding_up_panel/sliding_up_panel.dart';
// import 'package:serbizio_ph/src/features/services/controllers/parking_controller.dart';

class ServicesPage extends StatelessWidget {
  const ServicesPage({super.key});

  @override
  Widget build(BuildContext context) {
    // final serviceControlller = Get.put(ServiceController());
    // final size = HelperFunction.screenSize();
    final dark = HelperFunction.isDarkMode(context);

    return Scaffold(
      appBar: AppBar(
        backgroundColor: dark ? darkModeBackground : whiteColor,
        title: const Text('Services'),
      ),
      body: const Stack(
        alignment: Alignment.topCenter,
        children: [
          SizedBox(),
          // Positioned(
          //   right: 15.0,
          //   top: 15.0,
          //   child: SizedBox(
          //     width: 48,
          //     height: 48,
          //     child: FittedBox(
          //       child: FloatingActionButton(
          //         heroTag: 'location_button',
          //         onPressed: () => serviceControlller.currentLocationCamera(),
          //         backgroundColor: dark ? darkModeBackground : whiteColor,
          //         child: Icon(MingCute.location_2_line, color: dark ? whiteColor : textColor1),
          //       ),
          //     ),
          //   ),
          // ),
        ],
      ),
    );
  }
}

// Widget _buildSlidingPanel({required ScrollController scrollController, required ServiceController ServiceController, required BuildContext context}) {
//   final dark = HelperFunction.isDarkMode(context);

//   return Obx(() => Container(
//     decoration: BoxDecoration(
//       color: dark ? darkModeBackground : whiteColor,
//       borderRadius: const BorderRadius.vertical(top: Radius.circular(20.0)),
//     ),
//     child: ListView.builder(
//       padding: const EdgeInsets.fromLTRB(defaultSize, 90.0, defaultSize, defaultSize),
//       controller: scrollController,
//       itemCount: serviceControlller.listParking.length,
//       itemBuilder: (context, index) {
//         var item = serviceControlller.listParking[index];
//         if(serviceControlller.listParking.isEmpty) {
//           return const Center(child: CircularProgressIndicator());
//         }
//         return ServiceCard(service: item);
//       },
//     ),
//   ));
// }
