import 'package:flutter/material.dart';
import 'package:serbizio_ph/src/features/home/components/services_horizontal.dart';
import 'package:serbizio_ph/src/features/home/components/top_places_loading.dart';
import '../../../utils/data/global.dart';
import '../../home/components/home_category_comp.dart';
// import 'package:gap/gap.dart';
// import 'package:get/get.dart';
// import 'package:google_maps_flutter/google_maps_flutter.dart';
// import 'package:sliding_up_panel/sliding_up_panel.dart';
// import 'package:serbizio_ph/src/features/services/controllers/parking_controller.dart';

class ServicesPage extends StatefulWidget {
  const ServicesPage({super.key});
  @override
  // ignore: library_private_types_in_public_api
  _ServicesPageState createState() => _ServicesPageState();
}

class _ServicesPageState extends State<ServicesPage> with WidgetsBindingObserver {

  int _selectedFilter = 0;

  @override
  Widget build(BuildContext context) {
    // return Scaffold(
    //   appBar: AppBar(
    //     backgroundColor: dark ? darkModeBackground : whiteColor,
    //   ),

    return Scaffold(
      body: CustomScrollView(
        physics: const BouncingScrollPhysics(),
        slivers: [
          const SliverAppBar(
            automaticallyImplyLeading: false,
            backgroundColor: Colors.white,
            surfaceTintColor: Colors.transparent,
            snap: true,
            elevation: 4,
            floating: true,
            toolbarHeight: 150,
            title: Text(
              'Services',
              style: TextStyle(
                fontFamily: 'Epilogue',
                fontSize: 24.0,
                fontWeight: FontWeight.bold
              )
            ),
            // actions: [
            //   Padding(
            //     padding: const EdgeInsets.symmetric(horizontal: 2),
            //     child: InkWell(
            //       splashFactory: NoSplash.splashFactory,
            //       hoverColor: Colors.transparent,
            //       highlightColor: Colors.transparent,
            //       splashColor: Colors.transparent,
            //       child: Image.asset(
            //         "assets/images/logo.png",
            //       ),
            //     ),
            //   )
            // ],
          ),
          SliverToBoxAdapter(
            child: Padding(
              padding: const EdgeInsets.only(left: 14, right: 10, bottom: 7),
              child: SizedBox(
                height: 50,
                child: ListView.builder(
                  scrollDirection: Axis.horizontal,
                  itemCount: Global.filters.length,
                  itemBuilder: (context, index) {
                    return Categorycomp(
                      isSelected: _selectedFilter,
                      index: index,
                      category: Global.filters[index]["category"],
                      icon: Global.filters[index]["icon"],
                      callBack: _changeCategory
                    );
                  },
                ),
              ),
            ),
          ),
          !Global.isoffline
              ? const SliverToBoxAdapter(
                  child: SingleChildScrollView(
                    scrollDirection: Axis.horizontal,
                    child: Row(
                      children: [
                        ServicesHorizontalView(
                          image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTilViDFdYbcu8CrYEXhMU_7nr1DpQfzevXIQ&s",
                          serviceName: "Healthcare",
                          subTitle: "Access medical professionals and healthcare services",
                          tag: "Healthcare",
                          icon: Icons.health_and_safety
                        ),
                        ServicesHorizontalView(
                          image: "https://media.istockphoto.com/id/1409722748/photo/students-raising-hands-while-teacher-asking-them-questions-in-classroom.jpg?s=612x612&w=0&k=20&c=NbVChOV9wIbQOhUD6BqpouZHHBbyQ2rkSjaVfIhpMv8=",
                          serviceName: "Education",
                          subTitle: "Connect with educational institutions",
                          tag: "Education",
                          icon: Icons.school
                        ),
                        ServicesHorizontalView(
                          image: "https://media.istockphoto.com/id/1428412216/photo/a-male-chef-pouring-sauce-on-meal.jpg?s=612x612&w=0&k=20&c=8U3mrgWsuB7pB8axtGj89MXRkHDKodEli9F6wKgPT4A=",
                          serviceName: "Food & Beverage",
                          subTitle: "Discover catering services for culinary experiences",
                          tag: "Food & Beverage",
                          icon: Icons.food_bank
                        ),
                        ServicesHorizontalView(
                          image: "https://media.istockphoto.com/id/1456825248/photo/structural-engineer-and-architect-working-with-blueprints-discuss-at-the-outdoors.jpg?s=612x612&w=0&k=20&c=Eg9xbC2aedsbPnnSmkbvMIa-Je431L8K9_cS7FHMB5M=",
                          serviceName: "Construction",
                          subTitle: "Find contractors and construction services for residential",
                          tag: "Construction",
                          icon: Icons.construction
                        ),
                        ServicesHorizontalView(
                          image: "https://media.istockphoto.com/id/506788598/photo/four-lane-controlled-access-highway-in-poland.jpg?s=612x612&w=0&k=20&c=So_ZkLaLn3s3iUf0kFdll6TAcpKpvUUMSlVlWBYkbDU=",
                          serviceName: "Transportation",
                          subTitle: "Access logistics and transportation services for goods delivery",
                          tag: "Transportation",
                          icon: Icons.emoji_transportation
                        ),
                      ],
                    ),
                  ),
                )
              : const SliverToBoxAdapter(
                  child: SingleChildScrollView(
                    scrollDirection: Axis.horizontal,
                    child: Row(
                      children: [
                        Topplaceloadingcomp(),
                        Topplaceloadingcomp(),
                      ],
                    ),
                  ),
                ),
        ],
      ),
    );
  }

  void _changeCategory(index) => setState(() => _selectedFilter = index);
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
