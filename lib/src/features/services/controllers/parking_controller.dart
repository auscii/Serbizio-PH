import 'package:flutter/material.dart';
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:get/get.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:location/location.dart';
import 'package:serbizio_ph/src/features/services/models/parking_model.dart';
import 'package:serbizio_ph/src/utils/constants/images.dart';
import 'package:serbizio_ph/src/utils/helpers/network_manager.dart';
import 'package:serbizio_ph/src/utils/theme/widget_themes/snackbar_theme.dart';

class ServiceController extends GetxController {
  static ServiceController get instance => Get.find();

  RxList<ParkingModel> listParking = <ParkingModel>[].obs;
  var markers = <Marker>{}.obs;
  GoogleMapController? mapController;
  Location location = Location();
  Rx<BitmapDescriptor?> customIcon = Rx<BitmapDescriptor?>(null);

  @override
  void onInit() {
    super.onInit();
    fetchParkingInformation();
    loadCustomMarker();
  }

  void fetchParkingInformation() async {
    try {
      final isConnected = await NetworkManager.instance.isConnected();
      if (!isConnected) return;

      List<ParkingModel> list = <ParkingModel>[];

      FirebaseFirestore.instance
          .collection("Parking")
          .orderBy("parking_rfid_status", descending: true)
          .snapshots()
          .listen((QuerySnapshot<Map<String, dynamic>> event) {
        list.clear();
        for (var item in event.docs) {
          ParkingModel parking = ParkingModel(
            id: item.id,
            parkingAddress: item.get('parking_address'),
            parkingName: item.get('parking_name'),
            parkingDesc: item.get('parking_desc'),
            parkingLng: item.get('parking_longitude'),
            parkingLat: item.get('parking_latitude'),
            parkingGoogleLink: item.get('parking_google_link'),
            parkingWazeLink: item.get('parking_waze_link'),
            parkingAvailable: item.get('parking_available'),
            parkingTotal: item.get('parking_total'),
            parkingStatus: item.get('parking_status'),
            parkingRfidStatus: item.get('parking_rfid_status'),
          );
          list.add(parking);
        }
        listParking.assignAll(list);
        createMarkers(listParking);
      });
    } catch (e) {
      SnackBarTheme.errorSnackBar(title: 'Error', message: e.toString());
    }
  }

  void createMarkers(List<ParkingModel> listParking) {
    markers.clear();
    for (var parking in listParking) {
      var marker = Marker(
        markerId: MarkerId(parking.id ?? ''),
        position: LatLng(parking.parkingLat, parking.parkingLng),
        infoWindow: InfoWindow(
          title: parking.parkingName,
          snippet: parking.parkingDesc,
        ),
        icon: customIcon.value ?? BitmapDescriptor.defaultMarker, // Can customize this marker
      );
      markers.add(marker);
    }
  }

  void loadCustomMarker() async {
    customIcon.value = await BitmapDescriptor.fromAssetImage(
      const ImageConfiguration(size: Size(100.0, 100.0)),
      mapMarker,
    );
  }

}