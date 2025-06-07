import 'dart:async';
import 'package:connectivity_plus/connectivity_plus.dart';
import 'package:flutter/material.dart';
import 'package:gap/gap.dart';
import 'package:get/get.dart';
import 'package:serbizio_ph/src/features/home/components/home_category_comp.dart';
import 'package:serbizio_ph/src/features/home/components/team_comp.dart';
import 'package:serbizio_ph/src/features/home/components/services_horizontal.dart';
import 'package:serbizio_ph/src/features/home/components/top_places_loading.dart';
import 'package:serbizio_ph/src/features/home/controllers/home_controller.dart';
import 'package:serbizio_ph/src/features/home/pages/register_as_company_page.dart';
import 'package:serbizio_ph/src/features/home/pages/register_as_individual_page.dart';
import 'package:serbizio_ph/src/utils/constants/colors.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});
  @override
  // ignore: library_private_types_in_public_api
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> with WidgetsBindingObserver {

  final homeController = Get.put(HomeController());

  StreamSubscription? connection;

  bool isoffline = true;
  int counter = 1;
  int _selectedFilter = 0;

  List<String> images = [
    "https://images.unsplash.com/photo-1626606076701-cf4ae64b2b03?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1332&q=80",
    "https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Z29hJTIwYmVhY2h8ZW58MHx8MHx8fDA%3D&w=1000&q=80"
  ];

  final dynamic filters = [
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

  @override
  void initState() {
    _onStart();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    // final realmServices = Provider.of<RealmServices>(context);
    return Scaffold(
      // floatingActionButton: Container(
      //   padding: const EdgeInsets.only(top: 15.0),
      //   child: Row(
      //     mainAxisAlignment: MainAxisAlignment.end,
      //     children: [
      //       SizedBox(
      //         width: 48,
      //         height: 48,
      //         child: FittedBox(
      //           child: FloatingActionButton(
      //             heroTag: 'location_button',
      //             onPressed: () => homeController.currentLocationCamera(),
      //             backgroundColor: dark ? darkModeBackground : whiteColor,
      //             child: Icon(MingCute.location_2_line,
      //                 color: dark ? whiteColor : textColor1),
      //           ),
      //         ),
      //       ),
      //       const Gap(10.0),
      //       FloatingActionButton.extended(
      //         heroTag: 'rfid_button',
      //         onPressed: () {
      //           Get.to(() => const RFIDPage());
      //         },
      //         backgroundColor: dark ? darkModeBackground : whiteColor,
      //         icon: Icon(
      //             Icons.nfc_outlined, size: 20, color: dark ? whiteColor : textColor1),
      //         label: Text('RFID', style: TextStyle(
      //             fontSize: 16, color: dark ? whiteColor : textColor1)),
      //       ),
      //     ],
      //   ),
      // ),
      // floatingActionButtonLocation: FloatingActionButtonLocation.miniEndTop,
      body: CustomScrollView(
        physics: const BouncingScrollPhysics(),
        slivers: [
          SliverAppBar(
            automaticallyImplyLeading: false,
            // backgroundColor: primaryColor,
            backgroundColor: Colors.white,
            surfaceTintColor: Colors.transparent,
            snap: true,
            elevation: 4,
            floating: true,
            toolbarHeight: 150,
            title: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                Container(
                  padding: EdgeInsets.zero,
                  width: 350,
                  child: Image.asset(
                    "assets/images/serbizio-logo-horizontal.jpg",
                    fit: BoxFit.fill,
                    // height: 200,
                    // width: 220
                  ),
                )
              // InkWell(
              //   focusColor: Colors.transparent,
              //   hoverColor: Colors.transparent,
              //   splashColor: Colors.transparent,
              //   highlightColor: Colors.transparent,
              //   onTap: () {
              //     // globalProvider.toggleDrawer();
              //   },
              //   child: CircleAvatar(
              //     backgroundColor: Colors.blueGrey[200]!,
              //     backgroundImage: const NetworkImage(
              //       "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80",
              //     ),
              //   ),
              // ),
              // const Padding(
              //   padding: EdgeInsets.only(left: 10),
              //   child: Text(
              //     "Hello,",
              //     style: TextStyle(
              //       fontSize: 20,
              //       fontWeight: FontWeight.w200,
              //     ),
              //   ),
              // ),
              // const Padding(
              //   padding: EdgeInsets.only(left: 2),
              //   child: Text(
              //     "Kailash",
              //     style: TextStyle(
              //       fontSize: 24,
              //       fontWeight: FontWeight.w800,
              //       fontFamily: "Nunito",
              //     ),
              //   ),
              // )
            ]),
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
          /*
          SliverAppBar(
            automaticallyImplyLeading: false,
            toolbarHeight: 50,
            backgroundColor: primaryColor,
            pinned: true,
            title: InkWell(
              splashFactory: NoSplash.splashFactory,
              hoverColor: Colors.transparent,
              highlightColor: Colors.transparent,
              splashColor: Colors.transparent,
              onTap: () async {
                // final Map<String, dynamic>? country = await Navigator.push(
                //   context,
                //   CupertinoDialogRoute(
                //     builder: (context) {
                //       return const Setlocationscreen();
                //     },
                //     context: context,
                //   ),
                // );
                // setState(() {
                //   if (country != null) {
                //     _countryCode = country["countryCode"];
                //     _location = country["selectedCountry"];
                //   }
                // });
              },
              // child: Row(
              //   children: [
              //     const Icon(Icons.location_pin),
              //     Padding(
              //       padding: const EdgeInsets.symmetric(horizontal: 1),
              //       child: Text(_location.length > 18
              //           ? "${_location.substring(0, 17)}..."
              //           : _location),
              //     ),
              //     const Icon(
              //       Icons.arrow_drop_down,
              //       color: Colors.orange,
              //       size: 30,
              //     )
              //   ],
              // ),
            ),
            actions: <Widget>[
              // Using Stack to show Notification Badge
              Stack(
                children: <Widget>[
                  IconButton(
                      padding: const EdgeInsets.only(right: 4),
                      icon: const Icon(Icons.notifications),
                      onPressed: () {
                        setState(() {
                          counter = 0;
                        });
                        Navigator.push(context, CupertinoPageRoute(
                          builder: (context) {
                            return const NotificationScreen();
                          },
                        ));
                      }),
                  counter != 0
                      ? Positioned(
                          right: 11,
                          top: 10,
                          child: InkWell(
                            splashFactory: NoSplash.splashFactory,
                            hoverColor: Colors.transparent,
                            highlightColor: Colors.transparent,
                            splashColor: Colors.transparent,
                            onTap: () {
                              setState(() {
                                counter = 0;
                              });
                              Navigator.push(context, CupertinoPageRoute(
                                builder: (context) {
                                  return const NotificationScreen();
                                },
                              ));
                            },
                            child: Container(
                              padding: const EdgeInsets.all(2),
                              decoration: BoxDecoration(
                                color: Colors.red,
                                borderRadius: BorderRadius.circular(6),
                              ),
                              constraints: const BoxConstraints(
                                minWidth: 12,
                                maxHeight: 14,
                                minHeight: 10,
                              ),
                              child: Text(
                                '$counter',
                                style: const TextStyle(
                                  color: Colors.white,
                                  fontSize: 8,
                                ),
                                textAlign: TextAlign.center,
                              ),
                            ),
                          ),
                        )
                      : Container()
                ],
              ),
            ],
            surfaceTintColor: Colors.transparent,
          ),
          */

          /* ///--- SEARCH HERE ---///
          SliverToBoxAdapter(
            child: Container(
              padding: const EdgeInsets.only(bottom: 10),
              height: 50,
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Expanded(
                    flex: 4,
                    child: InkWell(
                      splashFactory: NoSplash.splashFactory,
                      hoverColor: Colors.transparent,
                      highlightColor: Colors.transparent,
                      splashColor: Colors.transparent,
                      customBorder: const OutlineInputBorder(
                        borderSide: BorderSide(
                          width: 1,
                          color: Colors.red,
                        ),
                      ),
                      onTap: () {
                        Navigator.push(context, CupertinoPageRoute(
                          builder: (context) {
                            return const SearchPage();
                          },
                        ));
                      },
                      child: Container(
                        decoration: BoxDecoration(
                          border: Border.fromBorderSide(
                            BorderSide(
                              width: 1,
                              color: Theme.of(context).colorScheme.secondary,
                            ),
                          ),
                          borderRadius: const BorderRadius.all(
                            Radius.circular(100),
                          ),
                        ),
                        padding: const EdgeInsets.symmetric(
                          horizontal: 20,
                          vertical: 10,
                        ),
                        margin: const EdgeInsets.only(left: 20, right: 0),
                        child: const Text("Search here..."),
                      ),
                    ),
                  ),
                  Expanded(
                    child: Container(
                      padding: const EdgeInsets.only(right: 15),
                      alignment: Alignment.centerRight,
                      child: InkWell(
                        onTap: () {
                          showModalBottomSheet(
                            context: context,
                            builder: (context) {
                              return Container(
                                height: 300,
                                color: Colors.red,
                              );
                            },
                          );
                        },
                        child: Container(
                          decoration: BoxDecoration(
                            gradient: const LinearGradient(
                              begin: Alignment.centerLeft,
                              end: Alignment.centerRight,
                              colors: [
                                Colors.orange,
                                Colors.yellow,
                              ],
                            ),
                            borderRadius: BorderRadius.circular(6),
                          ),
                          padding: const EdgeInsets.all(7),
                          child: const Icon(
                            Icons.filter,
                          ),
                        ),
                      ),
                    ),
                  )
                ],
              ),
            ),
          ),
          */
          SliverToBoxAdapter(
            child: Container(
              margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),
              child: const Text(
                "Join the Serbizio Community",
                style: TextStyle(
                  fontSize: 24,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
          ),
          SliverToBoxAdapter(
            child: Column(
              mainAxisAlignment: MainAxisAlignment.start,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Container(
                  margin: const EdgeInsets.symmetric(horizontal: 20),
                  child: const Text(
                    "Serbizio Instant Services connects you with trusted service providers and companies for all your needs, from household help to restaurant services, construction, and BPO. Whether you're seeking reliable professionals or offering your expertise, our platform links service providers with reputable companies, ensuring quality and trust on both sides. Explore our app to discover and hire the best services or showcase your skills to top employers—all at your fingertips.",
                    textAlign: TextAlign.justify,
                    style: TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.normal,
                    ),
                  ),
                ),
                Container(
                  padding: const EdgeInsets.only(left: 20, top: 20),
                  child: SizedBox(
                    height: 55,
                    child: ElevatedButton(
                      onPressed: () => Get.to(() => const RegisterAsIndividualPage()),
                      child: const Padding(
                        padding: EdgeInsets.symmetric(horizontal: 10),
                        child: Text(
                          "REGISTER AS INDIVIDUAL",
                          textAlign: TextAlign.justify,
                          style: TextStyle(
                            fontSize: 16,
                            color: Colors.white,
                            fontWeight: FontWeight.normal,
                          ),
                        )
                      )
                    ),
                  ),
                ),
                Container(
                  padding: const EdgeInsets.only(left: 20, top: 20),
                  child: SizedBox(
                    height: 55,
                    child: ElevatedButton(
                      onPressed: () => Get.to(() => const RegisterAsCompanyPage()),
                      style: ButtonStyle(
                        backgroundColor: MaterialStateProperty.all(otherColor),
                      ),
                      child: const Padding(
                        padding: EdgeInsets.symmetric(horizontal: 10),
                        child: Text(
                          "REGISTER AS COMPANY",
                          textAlign: TextAlign.justify,
                          style: TextStyle(
                            fontSize: 16,
                            color: whiteColor,
                            fontWeight: FontWeight.normal,
                          ),
                        )
                      )
                    ),
                  ),
                ),
              ],
            ),
          ),
          const SliverToBoxAdapter(
            child: Gap(30.0)
          ),
          SliverToBoxAdapter(
            child: Container(
              margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),
              child: const Text(
                "Services",
                style: TextStyle(
                  fontSize: 24,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ),
          ),
          SliverToBoxAdapter(
            child: Padding(
              padding: const EdgeInsets.only(left: 14, right: 10, bottom: 7),
              child: SizedBox(
                height: 50,
                child: ListView.builder(
                  scrollDirection: Axis.horizontal,
                  itemCount: filters.length,
                  itemBuilder: (context, index) {
                    return Categorycomp(
                      isSelected: _selectedFilter,
                      index: index,
                      category: filters[index]["category"],
                      icon: filters[index]["icon"],
                      callBack: _changeCategory
                    );
                  },
                ),
              ),
            ),
          ),
          // !isoffline
          //     ? SliverToBoxAdapter(
          //         // child: FutureBuilder(
          //         //   future: HomePlaces.getPlaces(
          //         //       filters[_selectedFilter]["category"], _countryCode),
          //         child: StreamBuilder<RealmResultsChanges<Place>>(
          //           stream: realmServices.realm
          //               .query<Place>(
          //                   "country == '$_countryCode' ${filters[_selectedFilter]["category"] != 'All' ? 'AND category == "${filters[_selectedFilter]['category']}"' : ''} SORT(_id ASC)")
          //               .changes,
          //           builder: (context, snapshot) {
          //             if (snapshot.connectionState == ConnectionState.waiting) {
          //               return SizedBox(
          //                 height: 290,
          //                 child: ListView(
          //                   scrollDirection: Axis.horizontal,
          //                   children: const [Homecardloadingcomp()],
          //                 ),
          //               );
          //             } else {
          //               if (snapshot.hasData &&
          //                   snapshot.data != null &&
          //                   snapshot.data!.results.isNotEmpty) {
          //                 final results = snapshot.data!.results;
          //                 return SizedBox(
          //                   height: 290,
          //                   child: ListView.builder(
          //                     itemCount:
          //                         results.length > 1 ? 2 : results.length,
          //                     scrollDirection: Axis.horizontal,
          //                     itemBuilder: (context, index) {
          //                       return results[index].isValid
          //                           ? Homecardcomp(
          //                               data: Placesmodel.fromJson(
          //                                   results[index]),
          //                             )
          //                           : const SizedBox(height: 0, width: 0);
          //                     },
          //                   ),
          //                 );
          //               }
          //             }
          //             return const SizedBox(
          //               height: 0,
          //               width: 0,
          //             );
          //           },
          //         ),
          //       )
          //     : const SliverToBoxAdapter(
          //         child: SingleChildScrollView(
          //           scrollDirection: Axis.horizontal,
          //           child: Row(
          //             children: [
          //               Homecardloadingcomp(),
          //               Homecardloadingcomp(),
          //               Homecardloadingcomp(),
          //             ],
          //           ),
          //         ),
          //       ),
          !isoffline
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
                          icon: Icons.school
                        ),
                        ServicesHorizontalView(
                          image: "https://media.istockphoto.com/id/1456825248/photo/structural-engineer-and-architect-working-with-blueprints-discuss-at-the-outdoors.jpg?s=612x612&w=0&k=20&c=Eg9xbC2aedsbPnnSmkbvMIa-Je431L8K9_cS7FHMB5M=",
                          serviceName: "Construction",
                          subTitle: "Find contractors and construction services for residential",
                          tag: "Construction",
                          icon: Icons.school
                        ),
                        ServicesHorizontalView(
                          image: "https://media.istockphoto.com/id/506788598/photo/four-lane-controlled-access-highway-in-poland.jpg?s=612x612&w=0&k=20&c=So_ZkLaLn3s3iUf0kFdll6TAcpKpvUUMSlVlWBYkbDU=",
                          serviceName: "Transportation",
                          subTitle: "Access logistics and transportation services for goods delivery",
                          tag: "Transportation",
                          icon: Icons.school
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
          // !isoffline
          //     ? StreamBuilder<RealmResultsChanges<Place>>(
          //         stream: realmServices.realm
          //             .query<Place>(
          //                 "country == '$_countryCode' ${filters[_selectedFilter]["category"] != 'All' ? 'AND category == "${filters[_selectedFilter]['category']}"' : ''} SORT(_id ASC)")
          //             .changes,
          //         builder: (context, snapshot) {
          //           if (snapshot.connectionState == ConnectionState.waiting) {
          //             return SliverList.builder(
          //               itemBuilder: (context, index) {
          //                 return const Homegridcardloadingcomp();
          //               },
          //               itemCount: 10,
          //             );
          //           } else {
          //             if (snapshot.hasData &&
          //                 snapshot.data != null &&
          //                 snapshot.data!.results.isNotEmpty) {
          //               final results = snapshot.data!.results;
          //               return SliverList.builder(
          //                 itemCount:
          //                     results.length > 2 ? results.length - 2 : 0,
          //                 itemBuilder: (context, index) {
          //                   return results[index].isValid
          //                       ? Homegridcardcomp(
          //                           data: Placesmodel.fromJson(
          //                             results[index + 2],
          //                           ),
          //                         )
          //                       : const SizedBox(height: 0, width: 0);
          //                 },
          //               );
          //             }
          //           }
          //           return SliverToBoxAdapter(
          //             child: SizedBox(
          //               height: 0,
          //               child: ListView(
          //                 scrollDirection: Axis.horizontal,
          //                 children: const [Homegridcardloadingcomp()],
          //               ),
          //             ),
          //           );
          //         },
          //       )
          //     : SliverList.builder(
          //         itemBuilder: (context, index) {
          //           return const Homegridcardloadingcomp();
          //         },
          //         itemCount: 10,
          //       ),
          SliverToBoxAdapter(
            child: Container(
              margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),
              child: const Text(
                "Our Team",
                style: TextStyle(
                  fontSize: 24,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ),
          ),
          const SliverToBoxAdapter(
            child: SingleChildScrollView(
              scrollDirection: Axis.horizontal,
              child: Padding(
                padding: EdgeInsets.only(left: 10, right: 10, top: 5),
                child: Row(
                  children: [
                    TeamComp(
                      teamProfileImageURL: "https://serbizio.com/assets/sean.png",
                      teamName: "Sean Walden Reyes",
                      teamMotto: "Committed to driving change and pushing boundaries to achieve excellence in all aspects of our business.",
                      teamPosition: "CEO & CTO",
                    ),
                    TeamComp(
                      teamProfileImageURL: "https://serbizio.com/assets/casey.png",
                      teamName: "Casey Dowling",
                      teamMotto: "My vision is to foster a culture of innovation that empowers our team to create impactful solutions for our clients.",
                      teamPosition: "CMO",
                    ),
                    TeamComp(
                      teamProfileImageURL: "https://serbizio.com/assets/julio.jpg",
                      teamName: "Julius Alexander Reyes",
                      teamMotto: "Believing in the power of collaboration, I strive to connect ideas and people to build a stronger, more resilient company.",
                      teamPosition: "CFO",
                    ),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
      


      // body: Obx(() {
      //   ParkingModel? parkingLocation = homeController.parkingLocation.value;
      //   return GoogleMap(
      //     onMapCreated: (GoogleMapController controller) {
      //       homeController.mapController = controller;
      //     },
      //     mapType: MapType.normal,
      //     zoomControlsEnabled: false,
      //     myLocationEnabled: true,
      //     myLocationButtonEnabled: false,
      //     trafficEnabled: true,
      //     initialCameraPosition: const CameraPosition(
      //       target: LatLng(3.07018, 101.49955), // Initial position
      //       zoom: 15,
      //     ),
      //     markers: parkingLocation != null ? {
      //       Marker(
      //         markerId: MarkerId(parkingLocation.id ?? ''),
      //         position: LatLng(parkingLocation.parkingLat, parkingLocation.parkingLng),
      //         icon: homeController.customIcon.value ?? BitmapDescriptor.defaultMarker,
      //         infoWindow: InfoWindow(
      //           title: parkingLocation.parkingName,
      //           snippet: parkingLocation.parkingDesc,
      //         ),
      //       ),
      //     } : {},
      //   );
      // }),
      // bottomNavigationBar: Obx(() {
      //   if(homeController.permissionStatus.value == PermissionStatus.denied) {
      //     return Container(
      //       height: 230,
      //       decoration: BoxDecoration(
      //         color: dark ? darkModeBackground : whiteColor,
      //         boxShadow: [
      //           BoxShadow(
      //             color: Colors.black.withOpacity(0.2),
      //             blurRadius: 10,
      //             offset: Offset.zero,
      //           ),
      //         ],
      //       ),
      //       child: Padding(
      //         padding: const EdgeInsets.all(defaultSize),
      //         child: Column(
      //           mainAxisAlignment: MainAxisAlignment.spaceBetween,
      //           children: [
      //             Image(
      //               image: const AssetImage(uniparkLogo),
      //               height: size.height * 0.04,
      //             ),
      //             Column(
      //               children: [
      //                 Text('PARKING SPACES',
      //                     style: TextStyle(fontSize: 18.0,
      //                         fontFamily: 'Epilogue',
      //                         fontWeight: FontWeight.bold,
      //                         color: dark ? whiteColor : blackColor)),
      //                 const Gap(10.0),
      //                 const Text('Locate the nearest parking spaces inside\n UiTM Shah Alam', textAlign: TextAlign.center,),
      //               ],
      //             ),
      //             SizedBox(
      //               width: double.infinity,
      //               child: ElevatedButton(
      //                 onPressed: () {
      //                   showModalBottomSheet(
      //                     isScrollControlled: true,
      //                     context: context,
      //                     backgroundColor: Colors.transparent,
      //                     builder: (BuildContext context) {
      //                       return Container(
      //                         padding: const EdgeInsets.all(10.0),
      //                         decoration: BoxDecoration(
      //                           color: dark ? darkModeBackground : whiteColor,
      //                           borderRadius: const BorderRadius.vertical(
      //                               top: Radius.circular(20.0)),
      //                         ),
      //                         child: Column(
      //                           crossAxisAlignment: CrossAxisAlignment.center,
      //                           mainAxisSize: MainAxisSize.min,
      //                           children: [
      //                             Container(
      //                               width: 50,
      //                               height: 5,
      //                               decoration: const BoxDecoration(
      //                                 color: borderColor,
      //                                 borderRadius: BorderRadius.all(
      //                                     Radius.circular(50.0)),
      //                               ),
      //                             ),
      //                             const Gap(30.0),
      //                             Column(
      //                               children: [
      //                                 Image(
      //                                   image: const AssetImage(locationDenied),
      //                                   height: size.height * 0.3,
      //                                 ),
      //                                 const Gap(10.0),
      //                                 Text('Enable location services', style: Theme.of(context).textTheme.headlineSmall),
      //                                 const Gap(20.0),
      //                                 const Text('This allows us to automatically find parking spaces near you', textAlign: TextAlign.center),
      //                                 const Gap(20.0),
      //                                 const Text('Go to Settings and then'),
      //                                 const Text('1. Go to Location'),
      //                                 const Text('2. Select UniPark application'),
      //                                 const Text('3. Tap Always or While Using'),
      //                                 const Text('4. Close and open the app'),
      //                                 const Gap(30.0),
      //                                 SizedBox(
      //                                   width: double.infinity,
      //                                   child: ElevatedButton(
      //                                     onPressed: () => AppSettings.openAppSettings(type: AppSettingsType.location),
      //                                     child: const Text('GO TO SETTINGS'),
      //                                   ),
      //                                 ),
      //                                 const Gap(20.0),
      //                               ],
      //                             ),
      //                           ],
      //                         ),
      //                       );
      //                     },
      //                   );
      //                 },
      //                 child: const Text('ENABLE LOCATION'),
      //               ),
      //             ),
      //           ],
      //         ),
      //       ),
      //     );
      //   }
        /*
        if(homeController.currentLocation.value == null) {
          Future.delayed(const Duration(seconds: 4));
          return const Center(child: CircularProgressIndicator());
        }
        return Container(
          decoration: BoxDecoration(
            color: dark ? darkModeBackground : whiteColor,
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.2),
                blurRadius: 10,
                offset: Offset.zero,
              ),
            ],
          ),
          child: Padding(
            padding: const EdgeInsets.all(defaultSize),
            child: Container(
              height: 200,
              padding: const EdgeInsets.all(defaultSize),
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(10.0),
                color: secondaryColor,
              ),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Text('NEAREST PARKING  •  ${homeController.parkingLocation
                      .value!.distance}', style: const TextStyle(
                      fontWeight: FontWeight.bold)),
                  Text(homeController.parkingLocation.value!.parkingName,
                      style: TextStyle(fontSize: 18.0,
                          fontFamily: 'Epilogue',
                          fontWeight: FontWeight.bold,
                          color: dark ? whiteColor : blackColor)),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(MingCute.car_3_line,
                          color: dark ? whiteColor : textColor1),
                      const Gap(5.0),
                      Text.rich(
                        TextSpan(text: "Parking Available: ",
                          children: [
                            TextSpan(
                                text: homeController.parkingLocation.value!
                                    .parkingRfidStatus ? "${homeController
                                    .parkingLocation.value!.parkingTotal -
                                    homeController.parkingLocation.value!
                                        .parkingAvailable}" : "not counted",
                                style: const TextStyle(
                                    fontWeight: FontWeight.w600)),
                          ],
                        ),
                      ),
                    ],
                  ),
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton(
                      onPressed: () {
                        showModalBottomSheet(
                          context: context,
                          backgroundColor: Colors.transparent,
                          builder: (BuildContext context) {
                            return Container(
                              padding: const EdgeInsets.all(10.0),
                              decoration: BoxDecoration(
                                color: dark ? darkModeBackground : whiteColor,
                                borderRadius: const BorderRadius.vertical(
                                    top: Radius.circular(20.0)),
                              ),
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.center,
                                mainAxisSize: MainAxisSize.min,
                                children: [
                                  Container(
                                    width: 50,
                                    height: 5,
                                    decoration: const BoxDecoration(
                                      color: borderColor,
                                      borderRadius: BorderRadius.all(
                                          Radius.circular(50.0)),
                                    ),
                                  ),
                                  const Gap(30.0),
                                  Text('Open in', style: Theme
                                      .of(context)
                                      .textTheme
                                      .headlineSmall),
                                  const Gap(10.0),
                                  Row(
                                    mainAxisAlignment: MainAxisAlignment
                                        .spaceEvenly,
                                    children: [
                                      GestureDetector(
                                        onTap: () {
                                          launchUrl(Uri.parse(
                                              homeController.parkingLocation
                                                  .value!.parkingWazeLink));
                                        },
                                        child: Column(
                                          children: [
                                            Image(
                                              image: const AssetImage(
                                                  wazeApp),
                                              height: size.height * 0.1,
                                            ),
                                            const Text('Waze'),
                                          ],
                                        ),
                                      ),
                                      GestureDetector(
                                        onTap: () {
                                          launchUrl(Uri.parse(
                                              homeController.parkingLocation
                                                  .value!.parkingGoogleLink));
                                        },
                                        child: Column(
                                          children: [
                                            Image(
                                              image: const AssetImage(
                                                  googleApp),
                                              height: size.height * 0.1,
                                            ),
                                            const Text('Google Maps'),
                                          ],
                                        ),
                                      ),
                                    ],
                                  ),
                                  const Gap(20.0),
                                ],
                              ),
                            );
                          },
                        );
                      },
                      child: const Text('GO TO PARKING'),
                    ),
                  ),
                ],
              ),
            ),
          ),
        );
        */
      // }
      // ),
    );
  }

  void _changeCategory(index) => setState(() => _selectedFilter = index);

  void _onStart() async {
    var result = await Connectivity().checkConnectivity();
    if (result == ConnectivityResult.mobile) {
        setState(() => isoffline = false);
    } else if (result == ConnectivityResult.wifi) {
        setState(() => isoffline = false);
    } else if (result == ConnectivityResult.ethernet) {
        setState(() => isoffline = false);
    } else if (result == ConnectivityResult.bluetooth) {
        setState(() => isoffline = false);
    } else if (result == ConnectivityResult.none) {
        setState(() => isoffline = true);
    }
  }

}
