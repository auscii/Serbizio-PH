import 'dart:io';
import 'package:device_info_plus/device_info_plus.dart';

class DeviceID {

  static Future<String?> get() async {
    var deviceInfo = DeviceInfoPlugin();
    if (Platform.isIOS) {
      var iosDeviceInfo = await deviceInfo.iosInfo;
      return iosDeviceInfo.identifierForVendor;
    } else if(Platform.isAndroid) {
      var device = await deviceInfo.androidInfo;
      return device.id;
    }
    return null;
  }

}