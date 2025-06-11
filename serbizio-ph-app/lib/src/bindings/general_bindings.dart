import 'package:get/get.dart';
import 'package:serbizio_ph/src/utils/helpers/network_manager.dart';

class GeneralBindings extends Bindings {

  @override
  void dependencies() {
    Get.put(NetworkManager());
  }
}