import 'package:flutter/material.dart';
import 'package:gap/gap.dart';
import 'package:get/get.dart';
import 'package:icons_plus/icons_plus.dart';
import 'package:serbizio_ph_web/src/features/authentication/controllers/account_deletion_controller.dart';
import 'package:serbizio_ph_web/src/utils/constants/colors.dart';
import 'package:serbizio_ph_web/src/utils/constants/images.dart';
import 'package:serbizio_ph_web/src/utils/constants/sizes.dart';
import 'package:serbizio_ph_web/src/utils/validators/validation.dart';
import 'package:serbizio_ph_web/src/utils/widgets/textformfield_outline_widget.dart';

class AccountDeletion extends StatelessWidget {
  const AccountDeletion({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SingleChildScrollView(
        child: Container(
          padding: const EdgeInsets.all(defaultSize),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              Container(
                padding: EdgeInsets.zero,
                width: 350,
                child: Image.asset(
                  appLogo,
                  fit: BoxFit.fill
                ),
              ),
              const Gap(5.0),
              Column(
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  const Text(
                    'User Account Deletion',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 24.0,
                      fontWeight: FontWeight.bold
                    )
                  ),
                  const Gap(5.0),
                  Container(
                    margin: const EdgeInsets.symmetric(horizontal: 20),
                    child: const Text(
                      "Please enter your email address and password to continue delete your account from Serbizio PH.",
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.normal,
                      ),
                    ),
                  ),
                ],
              ),
              const Gap(30.0),
              const RegisterFormWidget(),
            ],
          ),
        ),
      ),
    );
  }
}

class RegisterFormWidget extends StatelessWidget {
  const RegisterFormWidget({
    super.key
  });

  @override
  Widget build(BuildContext context) {
    final controller = Get.put(AccountDeletionController());

    return Container(
      alignment: Alignment.center,
      padding: const EdgeInsets.symmetric(vertical: formHeight - 10.0),
      child: Form(
        key: controller.registerFormKey,
        child: Column(
          children: [
            SizedBox(
              width: 400,
              child: WTextFormFieldOutline(
                controller: controller.email,
                keyboardType: TextInputType.emailAddress,
                obscureText: false,
                enableSuggestions: false,
                autocorrect: false,
                validator: (value) => Validations.validateEmail(value),
                labelText: 'Email Address',
                hintText: 'Enter your Email Address',
              ),
            ),
            const Gap(10.0),
            SizedBox(
              width: 400,
              child: Obx(() => WTextFormFieldOutline(
                controller: controller.pw,
                obscureText: controller.hidePassword.value,
                enableSuggestions: false,
                autocorrect: false,
                validator: (value) => Validations.validatePassword(value),
                labelText: 'Password',
                hintText: 'Enter your Password',
                suffixIcon: IconButton(
                  onPressed: () => controller.hidePassword.value = !controller.hidePassword.value,
                  icon: Icon(controller.hidePassword.value ? MingCute.eye_close_line : MingCute.eye_2_line),
                ),
              )),
            ),
            const Gap(10.0),
            SizedBox(
              width: 400,
              child: Obx(() => WTextFormFieldOutline(
                controller: controller.confirmPw,
                obscureText: controller.hidePassword.value,
                enableSuggestions: false,
                autocorrect: false,
                validator: (value) => Validations.checkPassword(value, controller.pw.text),
                labelText: 'Confirm Password',
                hintText: 'Confirm your Password',
                suffixIcon: IconButton(
                  onPressed: () => controller.hidePassword.value = !controller.hidePassword.value,
                  icon: Icon(controller.hidePassword.value ? MingCute.eye_close_line : MingCute.eye_2_line),
                ),
              ))
            ),
            const Gap(20.0),
            SizedBox(
              width: 400,
              child: ElevatedButton(
                onPressed: () {
                  controller.registerUser(context);
                },
                style: ButtonStyle(
                  backgroundColor: MaterialStateProperty.all(otherColor),
                ),
                child: const Text(
                  'SUBMIT',
                  style: TextStyle(
                    color: Colors.white
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}