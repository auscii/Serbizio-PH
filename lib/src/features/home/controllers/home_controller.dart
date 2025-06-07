import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:get/get.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:location/location.dart';
import 'package:serbizio_ph/src/features/services/models/parking_model.dart';
import 'package:serbizio_ph/src/utils/helpers/network_manager.dart';
import 'package:serbizio_ph/src/utils/theme/widget_themes/snackbar_theme.dart';

class HomeController extends GetxController {
  static HomeController get instance => Get.find();

  GoogleMapController? mapController;
  Location location = Location();
  List<ParkingModel> listParking = <ParkingModel>[];
  Rx<BitmapDescriptor?> customIcon = Rx<BitmapDescriptor?>(null);

  @override
  void onInit() {
    super.onInit();
    fetchParkingData();
  }

  void fetchParkingData() async {
    try {
      final isConnected = await NetworkManager.instance.isConnected();
      if (!isConnected) return;

      List<ParkingModel> list = <ParkingModel>[];

      FirebaseFirestore.instance
          .collection("Parking")
          .where("parking_status", isEqualTo: true)
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
      });
    } catch (e) {
      SnackBarTheme.errorSnackBar(title: 'Error', message: e.toString());
    }
  }

}
