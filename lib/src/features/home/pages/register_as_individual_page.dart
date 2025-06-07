import 'package:colorful_safe_area/colorful_safe_area.dart';
import 'package:flutter/material.dart';
import 'package:gap/gap.dart';
import 'package:get/get.dart';
import 'package:icons_plus/icons_plus.dart';
import 'package:serbizio_ph/src/features/home/pages/home_page.dart';
import 'package:serbizio_ph/src/utils/constants/sizes.dart';
import 'package:serbizio_ph/src/features/authentication/controllers/register_controller.dart';
import 'package:serbizio_ph/src/utils/helpers/helper_functions.dart';
import 'package:serbizio_ph/src/utils/validators/validation.dart';
import 'package:serbizio_ph/src/utils/widgets/textformfield_outline_widget.dart';

class RegisterAsIndividualPage extends StatelessWidget {
  const RegisterAsIndividualPage({super.key});

  @override
  Widget build(BuildContext context) {
    var size = HelperFunction.screenSize();
    // final dark = HelperFunction.isDarkMode(context);

    return Scaffold(
      body: ColorfulSafeArea(
        color: Colors.transparent,
        overflowRules: const OverflowRules.all(true),
        child: SingleChildScrollView(
          child: ConstrainedBox(
            constraints: BoxConstraints(
              maxHeight: size.height + 120,
            ),
            child: Container(
              padding: const EdgeInsets.all(defaultSize),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                children: [
                  const Gap(37.0),
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Align(
                        alignment: Alignment.topLeft,
                        child: Text(
                          'Register as Individual',
                          style: Theme.of(context).textTheme.headlineSmall,
                        ),
                      ),
                      const Gap(10.0),
                      Text(
                        'Enter your personal information',
                        style: Theme.of(context).textTheme.titleSmall,
                      ),
                    ],
                  ),
                  const RegisterFormWidget(),
                ],
              ),
            ),
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
    final controller = Get.put(RegisterController());

    return Container(
      padding: const EdgeInsets.symmetric(vertical: formHeight - 10.0),
      child: Form(
        key: controller.registerFormKey,
        child: Column(
          children: [
            // WTextFormField(
            //   controller: controller.ownerName,
            //   keyboardType: TextInputType.text,
            //   validator: (value) => Validations.validateEmptyText('Owner name', value),
            //   hintText: 'Enter Name',
            //   obscureText: false,
            //   enableSuggestions: false,
            //   autocorrect: false,
            // ),
            WTextFormFieldOutline(
              controller: controller.name,
              keyboardType: TextInputType.text,
              obscureText: false,
              enableSuggestions: false,
              autocorrect: false,
              validator: (value) => Validations.validateEmptyText('First Name', value),
              labelText: 'First Name',
              hintText: 'Enter your First Name',
            ),
            const Gap(10.0),
            WTextFormFieldOutline(
              controller: controller.middleName,
              keyboardType: TextInputType.text,
              obscureText: false,
              enableSuggestions: false,
              autocorrect: false,
              validator: (value) => Validations.validateEmptyText('Middle Name', value),
              labelText: 'Middle Name (Optional)',
              hintText: 'Enter your Middle Name',
            ),
            const Gap(10.0),
            WTextFormFieldOutline(
              controller: controller.lastName,
              keyboardType: TextInputType.text,
              obscureText: false,
              enableSuggestions: false,
              autocorrect: false,
              validator: (value) => Validations.validateEmptyText('Last Name', value),
              labelText: 'Last Name',
              hintText: 'Enter your Last Name',
            ),
            const Gap(10.0),
            WTextFormFieldOutline(
              controller: controller.email,
              keyboardType: TextInputType.emailAddress,
              obscureText: false,
              enableSuggestions: false,
              autocorrect: false,
              validator: (value) => Validations.validateEmail(value),
              labelText: 'Email (Optional)',
              hintText: 'Enter your Email Address',
            ),
            const Gap(10.0),
            Obx(
              () => WTextFormFieldOutline(
                controller: controller.password,
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
              ),
            ),
            const Gap(10.0),
            WTextFormFieldOutline(
              controller: controller.studentId,
              keyboardType: TextInputType.number,
              obscureText: false,
              enableSuggestions: false,
              autocorrect: false,
              validator: (value) => Validations.validateEmptyText('Phone', value),
              labelText: 'Mobile Number',
              hintText: 'Enter your Mobile Number',
              maxLength: 10,
            ),
            const Gap(20.0),
            SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: () => controller.registerUser(),
                child: const Text('REGISTER'),
              ),
            ),
            const Gap(20.0),
            Text(
              'OR',
              style: Theme.of(context).textTheme.titleSmall,
            ),
            const Gap(20.0),
            SizedBox(
              width: double.infinity,
              child: OutlinedButton(
                onPressed: () => Get.to(() => const HomePage()),
                child: const Text(
                  "BACK TO HOME", 
                  style: TextStyle(
                    // color: dark ? whiteColor : primaryColor,
                    fontWeight: FontWeight.bold
                  )
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}