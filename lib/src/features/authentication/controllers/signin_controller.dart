import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:serbizio_ph/src/data/repositories/user/user_repository.dart';
import 'package:serbizio_ph/src/data/repositories/authentication/authentication_repository.dart';
import 'package:serbizio_ph/src/features/core/controllers/user_controller.dart';
import 'package:serbizio_ph/src/utils/helpers/network_manager.dart';
import 'package:serbizio_ph/src/utils/theme/widget_themes/snackbar_theme.dart';

class SignInController extends GetxController {
  static SignInController get instance => Get.find();

  // TextField Controllers to get data from TextFields
  final email = TextEditingController(); // controller for email input
  final password = TextEditingController(); // controller for password input
  final hidePassword = true.obs; // Observable for hiding/showing password
  GlobalKey<FormState> signInFormKey = GlobalKey<FormState>(); // Form key for form validation
  final userController = Get.put(UserController());
  final userRepository = Get.put(UserRepository());

  // Call this function on register page ui
  Future<void> signInUser() async {
    try {
      // Check internet connection
      final isConnected = await NetworkManager.instance.isConnected();
      if (!isConnected) return;

      // Form Validation
      if (!signInFormKey.currentState!.validate()) return;

      // Sign In user with Firebase Authentication
      await AuthenticationRepository.instance.signInWithEmailAndPassword(email.text.trim(), password.text.trim());

      // Redirect
      AuthenticationRepository.instance.screenRedirect();
    } catch (e) {
      // Show some Generic Error to the user
      SnackBarTheme.errorSnackBar(title: 'Error', message: e.toString());
    } finally {
    }
  }

}