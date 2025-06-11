import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:serbizio_ph/src/data/repositories/authentication/authentication_repository.dart';
import 'package:serbizio_ph/src/data/repositories/user/user_repository.dart';
import 'package:serbizio_ph/src/features/core/models/user_model.dart';
import 'package:serbizio_ph/src/utils/data/global.dart';
import 'package:serbizio_ph/src/utils/helpers/loader.dart';
import 'package:serbizio_ph/src/utils/helpers/network_manager.dart';
import 'package:serbizio_ph/src/utils/theme/widget_themes/snackbar_theme.dart';

class RegisterIndividualController extends GetxController {
  static RegisterIndividualController get instance => Get.find();

  final firstName = TextEditingController();
  final middleName = TextEditingController();
  final lastName = TextEditingController();
  final email = TextEditingController();
  final pw = TextEditingController();
  final confirmPw = TextEditingController();
  final mobileNumber = TextEditingController();
  final hidePassword = true.obs;

  GlobalKey<FormState> registerFormKey = GlobalKey<FormState>();

  void registerUser(BuildContext context) async {
    FocusManager.instance.primaryFocus?.unfocus();
    Loader.show(context, 0);
    try {
      final isConnected = await NetworkManager.instance.isConnected();
      if (!isConnected) return;

      if (!registerFormKey.currentState!.validate()) return;

      final userCredential = await AuthenticationRepository.instance.createUserWithEmailAndPassword(
        email.text.trim(),
        pw.text.trim()
      );

      final newUser = UserModel(
        id: userCredential.user!.uid,
        firstName: firstName.text.trim(),
        middleName: middleName.text.trim(),
        lastName: lastName.text.trim(),
        emailAddress: email.text.trim(),
        pw: pw.text.trim(),
        mobileNumber: mobileNumber.text.trim(),
        deviceId: Global.deviceID
      );

      final userRepository = Get.put(UserRepository());
      await userRepository.saveUserRecord(newUser);

      AuthenticationRepository.instance.screenRedirect();

      SnackBarTheme.successSnackBar(title: 'Welcome', message: 'Your account has been created.');
      Loader.stop();
    } catch (e) {
      SnackBarTheme.errorSnackBar(title: 'Error', message: e.toString());
      Loader.stop();
    } finally {}
  }
}