import java.util.*;
public class array_practice2
{
	public static void main(String ars[])
	{
		Scanner sc=new Scanner(System.in);
		System.out.println("enter the size of an arrey:-");
		int size=sc.nextInt();
		int arr[]=new int[size];
		for(int i=0;i<size;i++)
		{
			System.out.println("enter values"+(i+1));
			arr[i]=sc.nextInt();
		}
		System.out.println("entered array");
		for(int i=0;i<size;i++)
		{
			System.out.print(arr[i]+",");		
		}
		System.out.println("enter a value to search:-");
		int s=sc.nextInt();
		int count=-1;
		for (int i=0;i<size;i++)
		{
			if(arr[i]==s)
			{
				count=i;
			}
		}
		if(count!=-1)
		{
			if(arr[count]>0 && arr[count]%2==0)
			{
				System.out.println("Number found, It is Positive and Even");
			}
			else if(arr[count]>0 && arr[count]%2!=0)
			{
				System.out.println("Number found, It is Positive and Odd");
			}
			else if(arr[count]<0 && arr[count]%2==0)
			{
				System.out.println("Number found, It is Negative and Even");
			}
			else
			{
				System.out.println("Number found, It is Negative and odd");	
			}
		}
		else
		{
			System.out.println("Item Not Found");
		}
	}
}
