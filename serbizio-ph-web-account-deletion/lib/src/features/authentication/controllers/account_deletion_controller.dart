import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:serbizio_ph_web/src/data/repositories/authentication/authentication_repository.dart';
import 'package:serbizio_ph_web/src/utils/helpers/loader.dart';
import 'package:serbizio_ph_web/src/utils/helpers/network_manager.dart';
import 'package:serbizio_ph_web/src/utils/theme/widget_themes/snackbar_theme.dart';

class AccountDeletionController extends GetxController {
  static AccountDeletionController get instance => Get.find();

  final email = TextEditingController();
  final pw = TextEditingController();
  final confirmPw = TextEditingController();
  final hidePassword = true.obs;

  GlobalKey<FormState> registerFormKey = GlobalKey<FormState>();

  void registerUser(BuildContext context) async {
    FocusManager.instance.primaryFocus?.unfocus();
    Loader.show(context, 0);

    try {
      final isConnected = await NetworkManager.instance.isConnected();
      if (!isConnected) return;

      if (!registerFormKey.currentState!.validate()) return;

      final userCredential = await AuthenticationRepository.instance.signInWithEmailAndPassword(
        email.text.trim(),
        pw.text.trim()
      );

      if (userCredential.user != null) {
        await AuthenticationRepository.instance.deleteAccount();
      } else {
        SnackBarTheme.errorSnackBar(title: 'Warning', message: "The SerbizioPH does not recognize the username or password. Please try again.");
      }

      clearFields();
      SnackBarTheme.successSnackBar(title: 'Success!', message: 'Your account has been Removed!');
    } catch (e) {
      clearFields();
      SnackBarTheme.errorSnackBar(title: 'Unable to Removed your Account!', message: e.toString());
    } finally {
      clearFields();
      SnackBarTheme.errorSnackBar(title: 'Warning', message: "SerbizioPH does not recognize the username or password. Please try again.");
    }
  }
  
  void clearFields() {
    Loader.stop();
    email.text = "";
    pw.text = "";
    confirmPw.text = "";
  }

}