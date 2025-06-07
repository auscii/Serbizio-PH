import 'package:get/get.dart';

class HomeController extends GetxController {
  static HomeController get instance => Get.find();

  @override
  void onInit() {
    super.onInit();
    // fetchParkingData();
  }

  // void fetchParkingData() async {
  //   try {
  //     final isConnected = await NetworkManager.instance.isConnected();
  //     if (!isConnected) return;

  //     List<ServicesModel> list = <ServicesModel>[];

  //     FirebaseFirestore.instance
  //         .collection("Parking")
  //         .where("parking_status", isEqualTo: true)
  //         .snapshots()
  //         .listen((QuerySnapshot<Map<String, dynamic>> event) {
  //       list.clear();
  //       for (var item in event.docs) {
  //         ServicesModel service = ServicesModel(
  //           id: item.id,
  //           parkingAddress: item.get('parking_address'),
  //           parkingName: item.get('parking_name'),
  //           parkingDesc: item.get('parking_desc'),
  //           parkingLng: item.get('parking_longitude'),
  //           parkingLat: item.get('parking_latitude'),
  //           parkingGoogleLink: item.get('parking_google_link'),
  //           parkingWazeLink: item.get('parking_waze_link'),
  //           parkingAvailable: item.get('parking_available'),
  //           parkingTotal: item.get('parking_total'),
  //           parkingStatus: item.get('parking_status'),
  //           parkingRfidStatus: item.get('parking_rfid_status'),
  //         );
  //         list.add(service);
  //       }
  //       listParking.assignAll(list);
  //     });
  //   } catch (e) {
  //     SnackBarTheme.errorSnackBar(title: 'Error', message: e.toString());
  //   }
  // }

}
